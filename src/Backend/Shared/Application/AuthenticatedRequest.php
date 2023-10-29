<?php

namespace Quatrevieux\Mvp\Backend\Shared\Application;

use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;
use Quatrevieux\Mvp\Core\SessionBearerInterface;

class AuthenticatedRequest implements SessionBearerInterface
{
    public ?AuthenticatedUser $user = null;

    public function setSession(object $session): void
    {
        $this->user = $session instanceof AuthenticatedUser ? $session : null;
    }

    public function session(): ?object
    {
        return $this->user;
    }
}
