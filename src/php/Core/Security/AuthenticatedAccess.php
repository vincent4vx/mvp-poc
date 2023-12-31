<?php

namespace Quatrevieux\Mvp\Core\Security;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Core\SessionBearerInterface;
use Quatrevieux\Mvp\Core\SessionHandler;
use Throwable;

class AuthenticatedAccess implements QueryAccessValidatorInterface
{
    public function __construct(
        private readonly SessionHandler $sessionHandler,
        private readonly ?SessionRoleCheckInterface $sessionRoleCheck = null,
        private readonly array $roles = [],
    ) {
    }

    public function withRoles(array $roles): self
    {
        return new self($this->sessionHandler, $this->sessionRoleCheck, $roles);
    }

    public function __invoke(object $query, ServerRequestInterface $serverRequest): AccessState
    {
        $session = $this->getSession($query, $serverRequest);

        if (!$session) {
            return AccessState::AuthenticationRequired;
        }

        if (!$this->roles) {
            return AccessState::Authorized;
        }

        if ($this->sessionRoleCheck) {
            foreach ($this->roles as $role) {
                if ($this->sessionRoleCheck->hasRole($session, $role)) {
                    return AccessState::Authorized;
                }
            }
        }

        return AccessState::NotEnoughPermissions;
    }

    private function getSession(object $query, ServerRequestInterface $serverRequest): ?object
    {
        if ($query instanceof SessionBearerInterface) {
            try {
                $session = $query->session();

                if ($session) {
                    return $session;
                }
            } catch (Throwable) {
                // Ignore potential type errors
            }
        }

        return $this->sessionHandler->resolve($serverRequest);
    }
}
