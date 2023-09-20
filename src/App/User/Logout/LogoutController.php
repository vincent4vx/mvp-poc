<?php

namespace Quatrevieux\Mvp\App\User\Logout;

use Quatrevieux\Mvp\Core\ControllerInterface;

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
