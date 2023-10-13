<?php

namespace Quatrevieux\Mvp\App\Chat\Event;

final class ChatEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {
    }
}
