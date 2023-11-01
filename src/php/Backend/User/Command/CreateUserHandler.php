<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\UserCreation;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserRepository;
use Quatrevieux\Mvp\Core\Bus\CommandHandlerInterface;

/**
 * @implements CommandHandlerInterface<CreateUser>
 */
final class CreateUserHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    public function handle(object $command): mixed
    {
        // @todo event
        return $this->repository->create(
            new UserCreation(
                username: $command->username,
                password: $command->password,
                pseudo: $command->pseudo,
            )
        );
    }

    public function commandClass(): string
    {
        return CreateUser::class;
    }
}
