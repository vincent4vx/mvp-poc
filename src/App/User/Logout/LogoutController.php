<?php

namespace Quatrevieux\Mvp\App\User\Logout;

use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(LogoutRequest::class)]
class LogoutController implements ControllerInterface
{
    /**
     * @param LogoutRequest $request
     * @return LogoutResponse
     */
    public function handle(object $request): object
    {
        return new LogoutResponse($request->session());
    }
}
