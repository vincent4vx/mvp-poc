<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\List;

use Quatrevieux\Mvp\Backend\BackOffice\BackOfficeRequest;
use Quatrevieux\Mvp\Backend\User\Domain\SearchUserCriteria;
use Quatrevieux\Mvp\Core\Route;

#[Route('/admin/users')]
class ListUsersRequest extends BackOfficeRequest
{
    public ?string $search = null;
    public array $fields = [];
    public bool $ajax = false;

    public static function ajax(): self
    {
        $request = new self();
        $request->ajax = true;

        return $request;
    }
}
