<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Delete;

class DeleteUserResponse
{
    public function __construct(
        private readonly bool $success,
    ) {
    }
}
