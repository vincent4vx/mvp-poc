<?php

namespace Quatrevieux\Mvp\Core\Bus;

/**
 * @template C as object
 */
interface CommandHandlerInterface
{
    /**
     * @param C $command
     * @return mixed
     */
    public function handle(object $command): mixed;

    /**
     * @return class-string<C>
     */
    public function commandClass(): string;
}
