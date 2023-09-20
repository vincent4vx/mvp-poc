<?php

namespace Quatrevieux\Mvp\App\User\Registration;

use Quatrevieux\Mvp\App\User\User;
use Quatrevieux\Mvp\App\User\UserRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;

class RegistrationController implements ControllerInterface
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    /**
     * @param RegistrationRequest $request
     * @return RegistrationResponse
     */
    public function handle(object $request): object
    {
        $errors = $request->validate($this->repository);

        if ($errors) {
            return new RegistrationResponse($request, false, null, $errors);
        }

        $user = new User(
            id: null,
            username: $request->username,
            password: $request->password,
            pseudo: $request->pseudo,
        );

        $user = $this->repository->create($user);

        return new RegistrationResponse($request, true, $user, []);
    }
}
