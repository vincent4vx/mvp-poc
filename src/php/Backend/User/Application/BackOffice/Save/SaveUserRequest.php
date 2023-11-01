<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save;

use Quatrevieux\Mvp\Backend\BackOffice\BackOfficeRequest;
use Quatrevieux\Mvp\Core\Route;

#[Route('/admin/user/save')]
class SaveUserRequest extends BackOfficeRequest
{
    public ?int $id = null;
    public ?string $pseudo = null;
    public ?string $password = null;
}
