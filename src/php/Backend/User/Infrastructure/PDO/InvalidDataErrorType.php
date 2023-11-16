<?php

namespace Quatrevieux\Mvp\Backend\User\Infrastructure\PDO;

enum InvalidDataErrorType
{
    case UNIQUE_CONSTRAINT_FAILED;
    case TOO_LONG;
    case INVALID_DATA;

    /**
     * Human readable error message for the user
     */
    public function simpleErrorMessage(): string
    {
        return match ($this) {
            self::UNIQUE_CONSTRAINT_FAILED => 'This value is already used.',
            self::TOO_LONG => 'This value is too long.',
            self::INVALID_DATA => 'This value is invalid.',
        };
    }

    public static function fromMysqlErrorCode(int $code): self
    {
        return match ($code) {
            1062 => self::UNIQUE_CONSTRAINT_FAILED,
            1406 => self::TOO_LONG,
            default => self::INVALID_DATA,
        };
    }
}
