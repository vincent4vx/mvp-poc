<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserRepository;
use Quatrevieux\Mvp\Core\Bus\CommandHandlerInterface;

class UpdateUserHandler
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    public function __invoke(UpdateUser $command): User
    {
        $updated = new User(
            id: $command->user->id,
            username: $command->user->username,
            password: $command->password,
            pseudo: $command->pseudo,
            roles: $command->roles,
        );

        $this->repository->update($updated);
        // @todo event

        return $updated;
    }
}
