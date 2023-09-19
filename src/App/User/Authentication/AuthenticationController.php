<?php

namespace Quatrevieux\Mvp\App\User\Authentication;

use Quatrevieux\Mvp\App\User\UserRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;

class AuthenticationController implements ControllerInterface
{
    public function __construct(
        private readonly UserRepository $repository,
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

        $user = $this->repository->findByUsername($request->username);

        if (!$user) {
            return new AuthenticationResponse($request->username, false);
        }

        // @todo: hash password
        if ($user->password !== $request->password) {
            return new AuthenticationResponse($request->username, false);
        }

        $payload = json_encode($user);
        $signature = hash_hmac('sha256', $payload, 'secret', true);
        $token = bin2hex($payload) . '.' . bin2hex($signature);

        return new AuthenticationResponse(
            $request->username,
            true,
            $user,
            $token
        );
    }
}
