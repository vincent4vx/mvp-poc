<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit;

use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(EditUserRequest::class)]
class EditUserController implements ControllerInterface
{
    public function __construct(
        private readonly UserReadRepositoryInterface $repository,
    ) {
    }

    /**
     * @param EditUserRequest $request
     * @return EditUserResponse
     */
    public function handle(object $request): object
    {
        $user = $this->repository->findById($request->id) ?? throw new \Exception('User not found');

        return new EditUserResponse(
            $user,
            $user->pseudo->value,
            []
        );
    }
}
