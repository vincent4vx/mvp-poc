<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\List;

use Quatrevieux\Mvp\Backend\User\Domain\User;

class ListUsersResponse
{
    /**
     * @var User[]
     */
    public readonly array $users;

    public function __construct(
        public readonly ListUsersRequest $request,
        User ...$users,
    ) {
        $this->users = $users;
    }
}
