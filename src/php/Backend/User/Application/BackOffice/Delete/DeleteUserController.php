<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Delete;

use Quatrevieux\Mvp\Backend\User\Command\DeleteUser;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Core\Bus\BusDispatcherInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(DeleteUserRequest::class)]
class DeleteUserController implements ControllerInterface
{
    public function __construct(
        private readonly UserReadRepositoryInterface $repository,
        private readonly BusDispatcherInterface $dispatcher,
    ) {
    }

    /**
     * @param DeleteUserRequest $request
     * @return DeleteUserResponse
     */
    public function handle(object $request): DeleteUserResponse
    {
        $user = $this->repository->findById($request->id);

        if ($user) {
            $this->dispatcher->dispatch(new DeleteUser($user));
        }

        return new DeleteUserResponse(true);
    }
}
