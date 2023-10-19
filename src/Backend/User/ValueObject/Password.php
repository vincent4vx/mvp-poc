<?php

namespace Quatrevieux\Mvp\Backend\User\ValueObject;

use BadMethodCallException;
use Quatrevieux\Mvp\Core\ValueObject\InvalidPrimitiveTypeError;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectException;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;

use function is_string;

final class Password implements ValueObjectInterface
{
    public function __construct(
        public readonly string $value,
    ) {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function verify(string $password): bool
    {
        // @todo handle password hash
        return $this->value === $password;
    }

    public function __toString(): string
    {
        throw new BadMethodCallException('Password cannot be converted to string');
    }

    public static function from(mixed $value): static
    {
        if (!is_string($value)) {
            throw new InvalidPrimitiveTypeError(self::class, 'string', $value);
        }

        return new static($value);
    }

    public static function tryFrom(mixed $value): ?static
    {
        if (!is_string($value)) {
            return null;
        }

        try {
            return self::from($value);
        } catch (ValueObjectException) {
            return null;
        }
    }
}
