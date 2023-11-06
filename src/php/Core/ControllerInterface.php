<?php

namespace Quatrevieux\Mvp\Core;

/**
 * @template R as object
 */
interface ControllerInterface
{
    /**
     * @param R $request
     * @return object
     */
    public function handle(object $request): object;
}
