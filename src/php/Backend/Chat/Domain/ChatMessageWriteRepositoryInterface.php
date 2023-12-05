<?php

namespace Quatrevieux\Mvp\Backend\Chat\Domain;

interface ChatMessageWriteRepositoryInterface
{
    public function add(ChatMessageCreation $message): ChatMessage;
}
