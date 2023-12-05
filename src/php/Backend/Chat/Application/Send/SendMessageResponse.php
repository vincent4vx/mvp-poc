<?php

namespace Quatrevieux\Mvp\Backend\Chat\Application\Send;

use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessage;

class SendMessageResponse
{
    public function __construct(
        public readonly ?ChatMessage $message = null,
    ) {
    }
}
