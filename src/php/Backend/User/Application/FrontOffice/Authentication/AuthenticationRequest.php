<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication;

use Quatrevieux\Mvp\Core\Route;

#[Route('/authentication')]
class AuthenticationRequest
{
    public string $username;
    public string $password;
}
