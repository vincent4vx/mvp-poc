<?php

namespace Quatrevieux\Mvp\App\Chat\Show;

use Quatrevieux\Mvp\App\User\User;

class ChatMessageWithUser
{
    public function __construct(
        public readonly int $id,
        public readonly string $message,
        public readonly \DateTimeImmutable $createdAt,
        public readonly ?User $user = null,
    ) {
    }
}
