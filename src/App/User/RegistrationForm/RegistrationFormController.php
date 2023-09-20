<?php

namespace Quatrevieux\Mvp\App\User\RegistrationForm;

use Quatrevieux\Mvp\Core\ControllerInterface;

class RegistrationFormController implements ControllerInterface
{
    public function handle(object $request): object
    {
        return new RegistrationFormResponse();
    }
}
