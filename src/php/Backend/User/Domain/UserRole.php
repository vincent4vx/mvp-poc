<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

enum UserRole: int
{
    case USER = 0;
    case MODERATOR = 1;
    case ADMIN = 2;

    public function label(): string
    {
        return match ($this) {
            self::USER => 'User',
            self::MODERATOR => 'Moderator',
            self::ADMIN => 'Administrator',
        };
    }
}
