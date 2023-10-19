<?php

namespace Quatrevieux\Mvp\Backend\Chat\Event;

final class ChatEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {
    }
}
