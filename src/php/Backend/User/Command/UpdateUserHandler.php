<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\InvalidDataException;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserRepository;

class UpdateUserHandler
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    public function __invoke(UpdateUser $command): UpdateUserResult
    {
        $updated = new User(
            id: $command->user->id,
            username: $command->user->username,
            password: $command->password,
            pseudo: $command->pseudo,
            roles: $command->roles,
        );

        try {
            $this->repository->update($updated);
            // @todo event
        } catch (InvalidDataException $e) {
            return new UpdateUserResult(null, [$e->field => $e->type->simpleErrorMessage()]);
        }

        return new UpdateUserResult($updated);
    }
}
