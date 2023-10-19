<?php

namespace Quatrevieux\Mvp\App\User\Logout;

use Quatrevieux\Mvp\App\User\AuthenticatedUser;
use Quatrevieux\Mvp\Core\Route;
use Quatrevieux\Mvp\Core\SessionBearerInterface;

#[Route('/logout')]
class LogoutRequest implements SessionBearerInterface
{
    private ?AuthenticatedUser $user = null;

    public function setSession(object $session): void
    {
        if ($session instanceof AuthenticatedUser) {
            $this->user = $session;
        }
    }

    public function session(): ?object
    {
        return $this->user;
    }
}
