<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\ModifiedUser;
use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\InvalidDataException;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserWriteRepository;

class UpdateUserHandler
{
    public function __construct(
        private readonly UserWriteRepository $repository,
    ) {
    }

    public function __invoke(UpdateUser $command): UpdateUserResult
    {
        $user = $command->user;

        if ($command->password) {
            $user = $user->withPassword($command->password);
        }

        if ($command->pseudo) {
            $user = $user->withPseudo($command->pseudo);
        }

        if ($command->roles) {
            $user = $user->withRoles($command->roles);
        }

        if (!$user instanceof ModifiedUser) {
            return new UpdateUserResult(null, [], 'No fields have been modified');
        }

        try {
            $user = $this->repository->update($user);
            // @todo event
        } catch (InvalidDataException $e) {
            return new UpdateUserResult(null, [$e->field => $e->type->simpleErrorMessage()]);
        }

        if ($user) {
            return new UpdateUserResult($user);
        } else {
            return new UpdateUserResult(null, [], 'User not found or not modified');
        }
    }
}
