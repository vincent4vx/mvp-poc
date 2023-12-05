<?php

namespace Quatrevieux\Mvp\Backend\Chat\Application\Show;

use DateTimeImmutable;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\ChatMessageId;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\MessageContent;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;

class ChatMessageWithUser
{
    public function __construct(
        public readonly ChatMessageId $id,
        public readonly MessageContent $message,
        public readonly DateTimeImmutable $createdAt,
        public readonly bool $isMine,
        public readonly ?Pseudo $pseudo,
    ) {
    }
}
