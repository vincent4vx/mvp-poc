<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication;

use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(AuthenticationRequest::class)]
class AuthenticationController implements ControllerInterface
{
    public function __construct(
        private readonly UserReadRepositoryInterface $repository,
    ) {
    }

    /**
     * @param AuthenticationRequest $request
     * @return AuthenticationResponse
     */
    public function handle(object $request): AuthenticationResponse
    {
        if (!isset($request->username) || !isset($request->password)) {
            return new AuthenticationResponse('', false);
        }

        $user = $this->repository
            ->findByUsername($request->username)
            ?->authenticate($request->password)
        ;

        if (!$user) {
            return new AuthenticationResponse($request->username, false);
        }

        return new AuthenticationResponse(
            $request->username,
            true,
            $user,
        );
    }
}
