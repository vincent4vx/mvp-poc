<?php

namespace Quatrevieux\Mvp\Backend\BackOffice\Security;

use DateTimeImmutable;
use Quatrevieux\Mvp\Backend\BackOffice\Home\HomeRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationResponse;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Router;

use function is_string;

/**
 * @implements ControllerInterface<UpgradeSessionRequest>
 */
class UpgradeSessionController implements ControllerInterface
{
    public function __construct(
        private readonly UserReadRepositoryInterface $repository,
        private readonly Router $router,
        private readonly string $pepper,
    ) {
    }

    public function handle(object $request): UpgradeSessionResponse|AuthenticationResponse
    {
        $user = $this->repository->findById($request->session()->id->value);

        if (!$user) {
            throw new \LogicException('User not found');
        }

        // @todo request serialization
        $target = $request->target ?? new HomeRequest();

        if (isset($target->user)) {
            $target = clone $target;
            unset($target->user);
        }

        $target = is_string($target) ? $target : $this->router->generate($target);

        if (!$request->password) {
            return new UpgradeSessionResponse(
                user: $user,
                target: $target,
            );
        }

        $session = $user->adminAuthentication($request->password, new DateTimeImmutable('+10 min'), $this->pepper);

        if (!$session) {
            return new UpgradeSessionResponse(
                user: $user,
                target: $target,
                error: 'Invalid password',
            );
        }

        return new AuthenticationResponse(
            username: $user->username->value,
            success: true,
            user: $session,
            target: $target,
        );
    }
}
