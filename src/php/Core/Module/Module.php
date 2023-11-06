<?php

namespace Quatrevieux\Mvp\Core\Module;

final class Module implements ModuleInterface
{
    public function __construct(
        public readonly array $routes,
        public readonly array $controllers,
        public readonly array $renderers,
        public readonly array $accessmap,
        public readonly array $definitions = [],
        public readonly array $handlers = [],
    ) {
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function controllers(): array
    {
        return $this->controllers;
    }

    public function renderers(): array
    {
        return $this->renderers;
    }

    public function accessmap(): array
    {
        return $this->accessmap;
    }

    public function definitions(): array
    {
        return $this->definitions;
    }

    public function handlers(): array
    {
        return $this->handlers;
    }

    public function withPrefix(string $prefix): static
    {
        $routes = [];

        foreach ($this->routes as $route => $request) {
            $routes[$prefix . $route] = $request;
        }

        return new Module(
            $routes,
            $this->controllers,
            $this->renderers,
            $this->accessmap,
            $this->definitions,
            $this->handlers,
        );
    }

    public function withDefaultAccess(callable|string $access): static
    {
        // TODO: Implement withDefaultAccess() method.
        return $this;
    }
}
