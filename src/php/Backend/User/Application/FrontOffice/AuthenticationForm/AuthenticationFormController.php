<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm;

use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;
use Quatrevieux\Mvp\Core\Security\AuthenticationRequiredRequest;

#[Handles(AuthenticationFormRequest::class)]
class AuthenticationFormController implements ControllerInterface
{
    public function handle(object $request): AuthenticationFormResponse
    {
        return new AuthenticationFormResponse(target: $request instanceof AuthenticationRequiredRequest ? $request->target : null);
    }
}
