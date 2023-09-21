<?php

namespace Quatrevieux\Mvp\App\User\Profile;

class ProfileResponse
{
    public function __construct(
        public readonly string $name,
        public readonly string $pseudo,
    ) {
    }
}
