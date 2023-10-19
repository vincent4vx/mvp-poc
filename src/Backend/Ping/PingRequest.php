<?php

namespace Quatrevieux\Mvp\Backend\Ping;

use Quatrevieux\Mvp\Core\Route;

#[Route('/ping')]
class PingRequest
{
    public ?string $message = null;
}
