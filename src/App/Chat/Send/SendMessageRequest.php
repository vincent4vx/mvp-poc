<?php

namespace Quatrevieux\Mvp\App\Chat\Send;

use Quatrevieux\Mvp\App\User\AuthenticatedUser;
use Quatrevieux\Mvp\Core\Route;
use Quatrevieux\Mvp\Core\SessionBearerInterface;

#[Route('/chat/send')]
class SendMessageRequest implements SessionBearerInterface
{
    public string $message;
    public ?AuthenticatedUser $user = null;

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