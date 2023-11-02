<?php

namespace Quatrevieux\Mvp\Core\Security;

interface SessionRoleCheckInterface
{
    public function hasRole(object $session, mixed $role): bool;
}
