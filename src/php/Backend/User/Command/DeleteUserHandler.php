<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\UserWriteRepositoryInterface;
use Quatrevieux\Mvp\Core\Bus\CommandHandlerInterface;

/**
 * @implements CommandHandlerInterface<DeleteUser>
 */
class DeleteUserHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserWriteRepositoryInterface $repository,
    ) {
    }

    public function handle(object $command): mixed
    {
        return $this->repository->delete($command->user);
    }

    public function commandClass(): string
    {
        return DeleteUser::class;
    }
}
