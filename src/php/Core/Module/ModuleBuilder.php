<?php

namespace Quatrevieux\Mvp\Core\Module;

use Quatrevieux\Mvp\Core\Security\QueryAccessValidatorFactories;
use Quatrevieux\Mvp\Core\Security\QueryAccessValidatorFactoryInterface;
use ReflectionNamedType;

use function rtrim;

class ModuleBuilder
{
    private mixed $defaultAccess = null;
    private string $prefix = '';

    public array $routes = [];
    public array $controllers = [];
    public array $renderers = [];
    public array $accessmap = [];
    public array $definitions = [];
    public array $handlers = [];

    public function route(string $route, string $request): RouteBuilder
    {
        return new RouteBuilder($this, $route, $request);
    }

    public function renderer(string $response, string $renderer): self
    {
        $this->renderers[$response] = $renderer;

        return $this;
    }

    public function build(): Module
    {
        // @todo check valid builder state
        return new Module(
            $this->buildRoutes(),
            $this->controllers,
            $this->renderers,
            $this->buildAccessMap(),
            $this->definitions,
            $this->handlers,
        );
    }

    public function defaultAccess(callable|string|QueryAccessValidatorFactoryInterface $access): self
    {
        $this->defaultAccess = $access;

        return $this;
    }

    public function anonymousByDefault(): self
    {
        return $this->defaultAccess(QueryAccessValidatorFactories::anonymous());
    }

    public function authenticatedByDefault(mixed ...$roles): self
    {
        return $this->defaultAccess(QueryAccessValidatorFactories::authenticated(...$roles));
    }

    public function prefix(string $prefix): self
    {
        $this->prefix .= $prefix;

        return $this;
    }

    public function definition(string $service, mixed $value): self
    {
        $this->definitions[$service] = $value;

        return $this;
    }

    public function handler(string $command, mixed $handler): self
    {
        $this->handlers[$command] = $handler;

        return $this;
    }

    private function buildRoutes(): array
    {
        if (!$this->prefix) {
            return $this->routes;
        }

        $routes = [];

        foreach ($this->routes as $route => $request) {
            $route = rtrim($this->prefix . $route, '/');
            $routes[$route] = $request;
        }

        return $routes;
    }

    private function buildAccessMap(): array
    {
        if (!$this->defaultAccess) {
            return $this->accessmap;
        }

        $accessmap = [];

        foreach ($this->routes as $route => $request) {
            $accessmap[$request] = $this->accessmap[$request] ?? $this->defaultAccess;
        }

        return $accessmap;
    }
}

class RouteBuilder
{
    private ?string $controller = null;
    private mixed $access = null;
    private array $renderers = [];

    public function __construct(
        private readonly ModuleBuilder $builder,
        private readonly string $route,
        private readonly string $request,
    ) {
    }

    public function controller(string $controller): self
    {
        $this->controller = $controller;

        return $this;
    }

    public function access(callable|string|QueryAccessValidatorFactoryInterface $access): self
    {
        $this->access = $access;

        return $this;
    }

    public function authenticated(mixed ...$roles): self
    {
        return $this->access(QueryAccessValidatorFactories::authenticated(...$roles));
    }

    public function anonymous(): self
    {
        return $this->access(QueryAccessValidatorFactories::anonymous());
    }

    public function renderer(string $renderer, ?string $response = null): self
    {
        if ($response === null) {
            $r = new \ReflectionMethod($this->controller, 'handle');
            $return = $r->getReturnType();

            if (!$return instanceof ReflectionNamedType || $return->isBuiltin()) {
                throw new \Exception('Cannot resolve response type from the controller '.$this->controller.'. Ensure that the controller has an atomic return type hint, or specify the response type manually');
            }

            $response = $return->getName();
        }

        $this->renderers[$response] = $renderer;

        return $this;
    }

    public function __destruct()
    {
        $this->builder->routes[$this->route] = $this->request;

        if ($this->controller) {
            $this->builder->controllers[$this->request] = $this->controller;
        }

        if ($this->access) {
            $this->builder->accessmap[$this->request] = $this->access;
        }

        $this->builder->renderers += $this->renderers;
    }
}
