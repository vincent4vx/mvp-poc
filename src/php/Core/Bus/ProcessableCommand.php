<?php

namespace Quatrevieux\Mvp\Core\Bus;

/**
 * @template R
 */
interface ProcessableCommand
{
    /**
     * @param mixed $response The response of the command handler
     * @return R
     */
    public function process(mixed $response): mixed;
}
