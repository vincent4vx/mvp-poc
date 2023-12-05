<?php

namespace Quatrevieux\Mvp\Backend\Chat\Domain;

use DateTimeImmutable;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\ChatMessageId;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\MessageContent;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;

final class ChatMessageCreation
{
    public function __construct(
        public readonly MessageContent $message,
        public readonly UserId $userId,
        public readonly DateTimeImmutable $createdAt,
    ) {
    }

    public function created(ChatMessageId $id): ChatMessage
    {
        return new ChatMessage(
            id: $id,
            message: $this->message,
            userId: $this->userId,
            createdAt: $this->createdAt,
        );
    }
}
