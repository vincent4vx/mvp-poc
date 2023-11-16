<?php

namespace Quatrevieux\Mvp\Core\Bus;

interface BusDispatcherInterface
{
    /**
     * Dispatch a command
     *
     * @param object|ProcessableCommand<R> $command
     * @return R
     *
     * @template R
     */
    public function dispatch(object $command): mixed;
}
