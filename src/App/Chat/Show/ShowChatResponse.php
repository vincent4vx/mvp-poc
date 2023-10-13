<?php

namespace Quatrevieux\Mvp\App\Chat\Show;

use Quatrevieux\Mvp\App\User\User;

class ShowChatResponse
{
    public function __construct(
        /**
         * @var ChatMessageWithUser[]
         */
        public readonly array $messages,
        public readonly ?User $user,
        public readonly bool $ajax = false,
    ) {
    }
}
