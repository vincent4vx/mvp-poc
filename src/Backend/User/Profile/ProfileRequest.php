<?php

namespace Quatrevieux\Mvp\Backend\User\Profile;

use Quatrevieux\Mvp\Backend\User\AuthenticatedUser;
use Quatrevieux\Mvp\Core\Route;
use Quatrevieux\Mvp\Core\SessionBearerInterface;

#[Route('/profile')]
class ProfileRequest implements SessionBearerInterface
{
    public ?AuthenticatedUser $user = null;

    public function setSession(object $session): void
    {
        if ($session instanceof AuthenticatedUser) {
            $this->user = $session;
        }
    }

    public function session(): ?AuthenticatedUser
    {
        return $this->user;
    }
}
