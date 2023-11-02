<?php

namespace Quatrevieux\Mvp\Backend\Domain\Security;

use LogicException;
use Quatrevieux\Mvp\Backend\User\Domain\UserRole;
use Quatrevieux\Mvp\Core\Security\SessionRoleCheckInterface;

final class SessionRoleCheck implements SessionRoleCheckInterface
{
    /**
     * {@inheritdoc}
     */
    public function hasRole(object $session, mixed $role): bool
    {
        if (!$session instanceof AuthenticatedUser) {
            return false;
        }

        if (!$role instanceof UserRole) {
            throw new LogicException('Role must be an instance of UserRole');
        }

        return $session->roles->is($role);
    }
}
