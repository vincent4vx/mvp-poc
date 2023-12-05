<?php

namespace Quatrevieux\Mvp\Backend\Chat\Domain;

use DateTimeImmutable;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\ChatMessageId;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\MessageContent;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;

final class ChatMessage
{
    public function __construct(
        public readonly ChatMessageId $id,
        public readonly MessageContent $message,
        public readonly ?UserId $userId,
        public readonly DateTimeImmutable $createdAt,
    ) {
    }
}
