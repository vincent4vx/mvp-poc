<?php

namespace Quatrevieux\Mvp\Core\Bus;

use Psr\Container\ContainerInterface;
use Quatrevieux\Mvp\Core\Util\ClassNameIterator;

class CommandDispatcherLoader
{
    public function __construct(
        private readonly string $namespace,
    ) {
    }

    public function load(ContainerInterface $container): CommandDispatcher
    {
        $handlers = [];

        $iterator = (new ClassNameIterator())
            ->namespace($this->namespace)
            ->implements(CommandHandlerInterface::class)
        ;

        foreach ($iterator as $class) {
            $handler = $container->get($class);
            $handlers[$handler->commandClass()] = $handler;
        }

        return new CommandDispatcher(...$handlers);
    }
}
