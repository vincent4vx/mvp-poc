<?php

namespace Quatrevieux\Mvp\Core;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Handles
{
    public function __construct(
        /**
         * @var class-string
         */
        public readonly string $requestClass,
    ) {
    }
}
