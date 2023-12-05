<?php

namespace Quatrevieux\Mvp\Backend\Chat\Command;

use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessage;
use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessageCreation;
use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessageWriteRepositoryInterface;

final class SendChatMessageHandler
{
    public function __construct(
        private readonly ChatMessageWriteRepositoryInterface $repository,
    ) {
    }

    public function __invoke(SendChatMessage $message): ChatMessage
    {
        $message = new ChatMessageCreation(
            message: $message->message,
            userId: $message->userId,
            createdAt: $message->createdAt,
        );

        return $this->repository->add($message);
    }
}
