<?php

namespace Quatrevieux\Mvp\App\User\Profile;

use Quatrevieux\Mvp\App\User\UserRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(ProfileRequest::class)]
class ProfileController implements ControllerInterface
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    /**
     * @param ProfileRequest $request
     * @return ProfileResponse
     */
    public function handle(object $request): ProfileResponse
    {
        $user = $this->repository->findById($request->user->id) ?? throw new \Exception('User not found');

        return new ProfileResponse(
            name: $user->username,
            pseudo: $user->pseudo,
        );
    }
}