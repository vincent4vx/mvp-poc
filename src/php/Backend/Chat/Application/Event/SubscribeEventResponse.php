<?php

namespace Quatrevieux\Mvp\Backend\Chat\Application\Event;

use Closure;
use Generator;

final class SubscribeEventResponse
{
    private string $lastEventId;

    public function __construct(
        /**
         * @var Closure(string|null): ChatEvent|null
         */
        private readonly Closure $generator,
    ) {
    }

    /**
     * @return Generator<ChatEvent>
     */
    public function events(): Generator
    {
        for (;;) {
            $event = ($this->generator)($this->lastEventId ?? null);

            if (!$event) {
                break;
            }

            $this->lastEventId = $event->id;
            yield $event;
        }
    }
}
