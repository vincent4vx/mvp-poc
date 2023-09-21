<?php

namespace Quatrevieux\Mvp\App\User\Profile;

use Quatrevieux\Mvp\App\User\User;
use Quatrevieux\Mvp\Core\Route;
use Quatrevieux\Mvp\Core\SessionBearerInterface;

#[Route('/profile')]
class ProfileRequest implements SessionBearerInterface
{
    public ?User $user = null;

    public function setSession(object $session): void
    {
        if ($session instanceof User) {
            $this->user = $session;
        }
    }

    public function session(): ?User
    {
        return $this->user;
    }
}
