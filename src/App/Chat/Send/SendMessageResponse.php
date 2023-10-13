<?php

namespace Quatrevieux\Mvp\App\Chat\Send;

use Quatrevieux\Mvp\App\Chat\ChatMessage;

class SendMessageResponse
{
    public function __construct(
        public readonly ?ChatMessage $message = null,
    ) {
    }
}
