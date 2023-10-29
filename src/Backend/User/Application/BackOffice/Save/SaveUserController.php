<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save;

use Exception;
use Quatrevieux\Mvp\Backend\User\Command\UpdateUser;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Core\Bus\BusDispatcherInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(SaveUserRequest::class)]
class SaveUserController implements ControllerInterface
{
    public function __construct(
        private readonly UserReadRepositoryInterface $repository,
        private readonly BusDispatcherInterface $dispatcher,
    ) {
    }

    /**
     * @param SaveUserRequest $request
     * @return SaveUserResponse
     */
    public function handle(object $request): SaveUserResponse
    {
        $user = $this->repository->findById($request->id) ?? throw new Exception('User not found');

        $pseudo = $user->pseudo;
        $password = $user->password;

        $errors = [];

        if ($request->pseudo) {
            try {
                $pseudo = Pseudo::from($request->pseudo);
            } catch (Exception $e) {
                $errors['pseudo'] = $e->getMessage();
            }
        }

        if ($request->password) {
            try {
                $password = Password::from($request->password);
            } catch (Exception $e) {
                $errors['password'] = $e->getMessage();
            }
        }

        if ($errors) {
            return new SaveUserResponse($request, $user, false, $errors);
        }

        $updatedUser = $this->dispatcher->dispatch(
            new UpdateUser($user, $pseudo, $password)
        );

        return new SaveUserResponse($request, $updatedUser, true);
    }
}
