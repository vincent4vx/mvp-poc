<?php

namespace Quatrevieux\Mvp\App\Chat\Send;

use Quatrevieux\Mvp\App\User\User;
use Quatrevieux\Mvp\Core\Route;
use Quatrevieux\Mvp\Core\SessionBearerInterface;

#[Route('/chat/send')]
class SendMessageRequest implements SessionBearerInterface
{
    public string $message;
    public User $user;

    public function setSession(object $session): void
    {
        if ($session instanceof User) {
            $this->user = $session;
        }
    }

    public function session(): ?object
    {
        return $this->user;
    }
}
