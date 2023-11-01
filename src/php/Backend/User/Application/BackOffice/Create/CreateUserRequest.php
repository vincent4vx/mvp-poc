<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create;

use Quatrevieux\Mvp\Backend\BackOffice\BackOfficeRequest;
use Quatrevieux\Mvp\Core\Route;

#[Route('/admin/user/create/save')]
class CreateUserRequest extends BackOfficeRequest
{
    public ?string $username = null;
    public ?string $pseudo = null;
    public ?string $password = null;
}
