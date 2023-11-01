<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm;

use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(RegistrationFormRequest::class)]
class RegistrationFormController implements ControllerInterface
{
    public function handle(object $request): object
    {
        return new RegistrationFormResponse();
    }
}
