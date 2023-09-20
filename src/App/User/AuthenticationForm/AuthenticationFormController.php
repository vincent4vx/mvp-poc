<?php

namespace Quatrevieux\Mvp\App\User\AuthenticationForm;

use Quatrevieux\Mvp\Core\ControllerInterface;

class AuthenticationFormController implements ControllerInterface
{
    public function handle(object $request): object
    {
        return new AuthenticationFormResponse();
    }
}
