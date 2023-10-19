<?php

namespace Quatrevieux\Mvp\Backend\Chat;

class ChatMessage
{
    public function __construct(
        public readonly int $id,
        public readonly string $message,
        public readonly int $userId,
        public readonly \DateTimeImmutable $createdAt,
    ) {
    }
}
