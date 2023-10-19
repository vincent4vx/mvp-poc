<?php

namespace Quatrevieux\Mvp\App\User\Registration;

use Quatrevieux\Mvp\App\User\User;
use Quatrevieux\Mvp\App\User\UserCreation;
use Quatrevieux\Mvp\App\User\UserRepository;
use Quatrevieux\Mvp\App\User\ValueObject\Password;
use Quatrevieux\Mvp\App\User\ValueObject\Pseudo;
use Quatrevieux\Mvp\App\User\ValueObject\UserId;
use Quatrevieux\Mvp\App\User\ValueObject\Username;
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
