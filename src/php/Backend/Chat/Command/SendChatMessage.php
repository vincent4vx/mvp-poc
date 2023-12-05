<?php

namespace Quatrevieux\Mvp\Backend\Chat\Command;

use DateTimeImmutable;
use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessage;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\MessageContent;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Core\Bus\ProcessableCommand;

/**
 * @implements ProcessableCommand<ChatMessage>
 */
class SendChatMessage implements ProcessableCommand
{
    public function __construct(
        public readonly MessageContent $message,
        public readonly UserId $userId,
        public readonly DateTimeImmutable $createdAt,
    ) {
    }

    public function process(mixed $response): ChatMessage
    {
        return $response;
    }
}
