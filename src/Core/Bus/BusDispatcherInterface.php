<?php

namespace Quatrevieux\Mvp\Core\Bus;

interface BusDispatcherInterface
{
    /**
     * Dispatch a command
     *
     * @param object $command
     * @return mixed
     */
    public function dispatch(object $command): mixed;
}
