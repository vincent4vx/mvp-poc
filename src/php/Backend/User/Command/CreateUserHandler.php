<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Domain\UserCreation;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserRepository;

final class CreateUserHandler
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    public function __invoke(CreateUser $command): User
    {
        // @todo event
        return $this->repository->create(
            new UserCreation(
                username: $command->username,
                password: $command->password,
                pseudo: $command->pseudo,
                roles: $command->roles,
            )
        );
    }
}
