<?php

namespace Quatrevieux\Mvp\App\User;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $password,
        public readonly string $pseudo,
    ) {
    }
}
