<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create;

use Quatrevieux\Mvp\Backend\User\Command\CreateUser;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Domain\UserRole;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;
use Quatrevieux\Mvp\Core\Bus\BusDispatcherInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectException;

#[Handles(CreateUserRequest::class)]
class CreateUserController implements ControllerInterface
{
    public function __construct(
        private readonly UserReadRepositoryInterface $repository,
        private readonly BusDispatcherInterface $dispatcher,
    ) {
    }

    /**
     * @param CreateUserRequest $request
     * @return object
     */
    public function handle(object $request): CreateUserResponse
    {
        $errors = [];

        if (!$request->username) {
            $errors['username'] = 'Username is required';
        }

        if (!$request->pseudo) {
            $errors['pseudo'] = 'Pseudo is required';
        }

        if (!$request->password) {
            $errors['password'] = 'Password is required';
        }

        try {
            $username = Username::from($request->username);

            if ($this->repository->hasUsername($username->value)) {
                $errors['username'] = 'Username already exists';
            }
        } catch (ValueObjectException $e) {
            $errors['username'] = $e->getMessage();
        }

        try {
            $pseudo = Pseudo::from($request->pseudo);
        } catch (ValueObjectException $e) {
            $errors['pseudo'] = $e->getMessage();
        }

        try {
            $password = Password::from($request->password);
        } catch (ValueObjectException $e) {
            $errors['password'] = $e->getMessage();
        }

        try {
            $roles = UserRolesSet::fromRoles(
                ...array_map(
                    UserRole::from(...),
                    $request->roles
                )
            );
        } catch (ValueObjectException $e) {
            $errors['roles'] = $e->getMessage();
        }

        if ($errors) {
            return new CreateUserResponse($request, false, $errors);
        }

        $user = $this->dispatcher->dispatch(
            new CreateUser($username, $pseudo, $password, $roles)
        );

        return new CreateUserResponse($request, true, [], $user);
    }
}
