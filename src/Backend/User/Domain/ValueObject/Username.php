<?php

namespace Quatrevieux\Mvp\Backend\User\Domain\ValueObject;

use Quatrevieux\Mvp\Core\ValueObject\DisplayStringValueObject;
use Quatrevieux\Mvp\Core\ValueObject\InvalidValueException;

use function ctype_alnum;
use function is_scalar;
use function strlen;
use function trim;

final class Username extends DisplayStringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);

        if (empty($value)) {
            throw new InvalidValueException(self::class, 'Username must be at least 3 characters long');
        }

        if (strlen($value) > 32) {
            throw new InvalidValueException(self::class, 'Username must be at most 32 characters long');
        }

        if (!ctype_alnum($value)) {
            throw new InvalidValueException(self::class, 'Username must be alphanumeric');
        }
    }

    public static function tryFrom(mixed $value): ?static
    {
        if (!is_scalar($value)) {
            return null;
        }

        return parent::tryFrom(trim((string) $value));
    }
}
