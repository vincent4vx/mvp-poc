<?php

namespace Quatrevieux\Mvp\App\Chat\Show;

use Quatrevieux\Mvp\App\User\AuthenticatedUser;
use Quatrevieux\Mvp\App\User\User;
use Quatrevieux\Mvp\Core\Route;
use Quatrevieux\Mvp\Core\SessionBearerInterface;

#[Route('/chat/show')]
class ShowChatRequest implements SessionBearerInterface
{
    public ?AuthenticatedUser $user = null;
    public bool $ajax = false;

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

    public static function ajax(): self
    {
        $request = new self();
        $request->ajax = true;

        return $request;
    }
}
