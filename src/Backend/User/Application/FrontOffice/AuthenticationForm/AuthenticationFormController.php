<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm;

use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(AuthenticationFormRequest::class)]
class AuthenticationFormController implements ControllerInterface
{
    public function handle(object $request): object
    {
        return new AuthenticationFormResponse();
    }
}
