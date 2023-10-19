<?php

namespace Quatrevieux\Mvp\Backend\Chat\Show;

use Quatrevieux\Mvp\Backend\User\User;

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
