<?php

namespace Quatrevieux\Mvp\App\Error;

use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\ErroredRequest;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(ErroredRequest::class)]
class ErrorController implements ControllerInterface
{
    public function handle(object $request): object
    {
        return $request;
    }
}
