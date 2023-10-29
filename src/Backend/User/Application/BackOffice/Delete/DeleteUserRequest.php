<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Delete;

// @todo csrf
use Quatrevieux\Mvp\Core\Route;

#[Route('/admin/user/delete')]
class DeleteUserRequest
{
    public function __construct(
        public ?int $id = null,
    ) {
    }
}
