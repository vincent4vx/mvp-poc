<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

class SearchUserCriteria
{
    public ?string $username = null;
    public ?string $pseudo = null;
    public ?int $id = null;
    public ?int $offset = null;
    public ?int $limit = null;
    public bool $or = false;
}
