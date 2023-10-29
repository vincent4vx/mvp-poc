<?php

namespace Quatrevieux\Mvp\Backend\User\Domain\ValueObject;

use Quatrevieux\Mvp\Core\ValueObject\DisplayStringValueObject;
use Quatrevieux\Mvp\Core\ValueObject\InvalidValueException;

use function is_scalar;
use function trim;

final class Pseudo extends DisplayStringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);

        if (empty($value)) {
            throw new InvalidValueException(self::class, 'Pseudo must be at least 3 characters long');
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
