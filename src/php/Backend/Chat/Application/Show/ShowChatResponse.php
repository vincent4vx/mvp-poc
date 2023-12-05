<?php

namespace Quatrevieux\Mvp\Backend\Chat\Application\Show;

class ShowChatResponse
{
    public function __construct(
        /**
         * @var ChatMessageWithUser[]
         */
        public readonly array $messages,
        public readonly bool $ajax = false,
    ) {
    }
}
