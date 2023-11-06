<?php

namespace Quatrevieux\Mvp\Core\Bus;

class CommandDispatcher implements BusDispatcherInterface
{
    public function __construct(
        /**
         * @var array<class-string, callable>
         */
        private readonly array $handlers
    ) {
    }

    public function dispatch(object $command): mixed
    {
        $handler = $this->handlers[$command::class] ?? throw new \InvalidArgumentException('No handler found for command ' . $command::class);

        return $handler($command);
    }
}
