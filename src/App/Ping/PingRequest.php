<?php

namespace Quatrevieux\Mvp\App\Ping;

use Quatrevieux\Mvp\Core\Route;

#[Route('/ping')]
class PingRequest
{
    public ?string $message = null;
}
