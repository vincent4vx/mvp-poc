<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Container\ContainerInterface;

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
        $controller = $this->controllers[get_class($query)] ?? null;

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
