<?php

namespace Quatrevieux\Mvp\App\User\Authentication;

use Quatrevieux\Mvp\Core\Route;

#[Route('/authentication')]
class AuthenticationRequest
{
    public string $username;
    public string $password;
}
