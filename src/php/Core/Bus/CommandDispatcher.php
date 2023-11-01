<?php

namespace Quatrevieux\Mvp\Core\Bus;

class CommandDispatcher implements BusDispatcherInterface
{
    /**
     * @var array<class-string, CommandHandlerInterface>
     */
    private readonly array $handlers;

    public function __construct(CommandHandlerInterface ...$handlers)
    {
        $handlersByCommand = [];

        foreach ($handlers as $handler) {
            $handlersByCommand[$handler->commandClass()] = $handler;
        }

        $this->handlers = $handlersByCommand;
    }

    public function dispatch(object $command): mixed
    {
        $handler = $this->handlers[get_class($command)] ?? throw new \InvalidArgumentException('No handler found for command ' . $command::class);

        return $handler->handle($command);
    }
}
