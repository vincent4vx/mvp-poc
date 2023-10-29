<?php

namespace Quatrevieux\Mvp\Backend\Chat\Show;

use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;

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
