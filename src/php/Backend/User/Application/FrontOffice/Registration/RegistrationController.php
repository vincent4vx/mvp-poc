<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration;

use Quatrevieux\Mvp\Backend\User\Command\CreateUser;
use Quatrevieux\Mvp\Backend\User\Domain\UserCreation;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserWriteRepository;
use Quatrevieux\Mvp\Core\Bus\BusDispatcherInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(RegistrationRequest::class)]
class RegistrationController implements ControllerInterface
{
    public function __construct(
        private readonly BusDispatcherInterface $dispatcher,
        private readonly UserReadRepositoryInterface $repository,
    ) {
    }

    /**
     * @param RegistrationRequest $request
     * @return RegistrationResponse
     */
    public function handle(object $request): RegistrationResponse
    {
        $errors = $request->validate($this->repository);

        if ($errors) {
            return new RegistrationResponse($request, false, null, $errors);
        }

        $result = $this->dispatcher->dispatch(new CreateUser(
            username: new Username($request->username),
            pseudo: new Pseudo($request->pseudo),
            password: new Password($request->password),
        ));

        if  ($result->errors || !$result->user) {
            return new RegistrationResponse($request, false, null, $result->errors);
        }

        return new RegistrationResponse($request, true, $result->user, []);
    }
}
