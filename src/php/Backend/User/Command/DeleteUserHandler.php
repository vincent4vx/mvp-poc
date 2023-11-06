<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\UserWriteRepositoryInterface;

class DeleteUserHandler
{
    public function __construct(
        private readonly UserWriteRepositoryInterface $repository,
    ) {
    }

    public function __invoke(DeleteUser $command): bool
    {
        return $this->repository->delete($command->user);
    }
}
