<?php

namespace Quatrevieux\Mvp\Core\Bus;

use Psr\Container\ContainerInterface;

use function is_string;

class CommandDispatcherLoader
{
    public function __construct(
        private readonly ContainerInterface $container,
    ) {
    }

    public function load(array $handlers): CommandDispatcher
    {
        $loaded = [];

        foreach ($handlers as $command => $handler) {
            if (is_string($handler)) {
                $loaded[$command] = $this->container->get($handler);
            } else {
                $loaded[$command] = $handler;
            }
        }

        return new CommandDispatcher($loaded);
    }
}
