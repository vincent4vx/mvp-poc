<?php

namespace Quatrevieux\Mvp\App\Chat\Show;

use Quatrevieux\Mvp\App\User\AuthenticatedUser;

class ShowChatResponse
{
    public function __construct(
        /**
         * @var ChatMessageWithUser[]
         */
        public readonly array $messages,
        public readonly ?AuthenticatedUser $user,
        public readonly bool $ajax = false,
    ) {
    }
}
