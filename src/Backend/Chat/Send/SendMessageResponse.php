<?php

namespace Quatrevieux\Mvp\Backend\Chat\Send;

use Quatrevieux\Mvp\Backend\Chat\ChatMessage;

class SendMessageResponse
{
    public function __construct(
        public readonly ?ChatMessage $message = null,
    ) {
    }
}
