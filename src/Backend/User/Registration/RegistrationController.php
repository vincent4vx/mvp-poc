<?php

namespace Quatrevieux\Mvp\Backend\User\Registration;

use Quatrevieux\Mvp\Backend\User\UserCreation;
use Quatrevieux\Mvp\Backend\User\UserRepository;
use Quatrevieux\Mvp\Backend\User\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\ValueObject\Username;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(RegistrationRequest::class)]
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

        $user = new UserCreation(
            username: new Username($request->username),
            password: new Password($request->password),
            pseudo: new Pseudo($request->pseudo),
        );

        $user = $this->repository->create($user);

        return new RegistrationResponse($request, true, $user, []);
    }
}
