<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;

enum ModifiableUserField: string
{
    case Password = 'password';
    case Pseudo = 'pseudo';
    case Roles = 'roles';

    public function value(AbstractUser $user): ValueObjectInterface
    {
        return match ($this) {
            self::Password => $user->password,
            self::Pseudo => $user->pseudo,
            self::Roles => $user->roles,
        };
    }
}
