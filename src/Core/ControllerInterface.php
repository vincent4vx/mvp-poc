<?php

namespace Quatrevieux\Mvp\Core;

interface ControllerInterface
{
    public function handle(object $request): object;
}
