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
    public int $page = 1;
    public bool $ajax = false;

    public function withPage(int $page): self
    {
        $request = clone $this;
        $request->page = $page;
        $request->user = null;
        $request->ajax = false;

        return $request;
    }

    public static function ajax(): self
    {
        $request = new self();
        $request->ajax = true;

        return $request;
    }
}
