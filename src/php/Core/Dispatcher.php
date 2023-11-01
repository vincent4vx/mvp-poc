<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Container\ContainerInterface;

use function is_string;

class Dispatcher
{
    public function __construct(
        private readonly ContainerInterface $container,

        /**
         * @var array<class-string, class-string>
         */
        private readonly array $controllers = [],
    ) {
    }

    public function dispatch(RoutedQuery $query): HandledQuery
    {
        return $query->withResponse($this->handle($query->query));
    }

    public function handle(object $query): object
    {
        $controller = $this->controllers[$query::class] ?? null;

        if ($controller === null) {
            throw new \InvalidArgumentException('Controller not found');
        }

        $controller = $this->container->get($controller);

        if (!$controller instanceof ControllerInterface) {
            throw new \InvalidArgumentException('Controller must implement ControllerInterface');
        }

        return $controller->handle($query);
    }
}
