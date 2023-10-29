<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit;

use Quatrevieux\Mvp\Backend\BackOffice\BackOfficeRequest;
use Quatrevieux\Mvp\Core\Route;

#[Route('/admin/user/edit')]
class EditUserRequest extends BackOfficeRequest
{
    public function __construct(
        public ?int $id = null
    ) {
    }
}
