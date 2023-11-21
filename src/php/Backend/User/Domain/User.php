<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

use DateTimeInterface;
use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;

class User extends AbstractUser
{
    public function authenticate(string $inputPassword, string $pepper): ?AuthenticatedUser
    {
        return AuthenticatedUser::create($this, $inputPassword, $pepper);
    }

    public function adminAuthentication(string $inputPassword, DateTimeInterface $adminSessionExpiration, string $pepper): ?AuthenticatedUser
    {
        return AuthenticatedUser::createAdminSession($this, $adminSessionExpiration, $inputPassword, $pepper);
    }

    protected function addToModifiedFields(ModifiableUserField $field): array
    {
        return [$field];
    }
}
