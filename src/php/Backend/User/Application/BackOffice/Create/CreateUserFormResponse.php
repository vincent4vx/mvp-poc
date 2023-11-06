<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create;

class CreateUserFormResponse
{
    public function __construct(
        public readonly ?string $username = null,
        public readonly ?string $pseudo = null,
        public readonly array $roles = [],
        public readonly array $errors = [],
    ) {
    }
}
