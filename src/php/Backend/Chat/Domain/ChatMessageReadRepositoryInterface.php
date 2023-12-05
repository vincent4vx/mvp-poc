<?php

namespace Quatrevieux\Mvp\Backend\Chat\Domain;

interface ChatMessageReadRepositoryInterface
{
    /**
     * @return ChatMessage[]
     */
    public function all(): array;

    public function lastMessageId(): int;
}
