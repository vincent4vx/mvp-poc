<?php

namespace Quatrevieux\Mvp\Backend\User\ValueObject;

use JsonSerializable;
use Quatrevieux\Mvp\Core\ValueObject\InvalidPrimitiveTypeError;
use Quatrevieux\Mvp\Core\ValueObject\InvalidValueException;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectException;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;

use function is_int;

final class UserId implements ValueObjectInterface, JsonSerializable
{
    public function __construct(
        public readonly int $value,
    )
    {
        if($value < 1){
            throw new InvalidValueException(self::class, 'User id must be greater than 0');
        }
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    public static function from(mixed $value): static
    {
        if(!is_int($value)){
            throw new InvalidPrimitiveTypeError(self::class, 'int', $value);
        }

        return new static($value);
    }

    public static function tryFrom(mixed $value): ?static
    {
        if(!is_int($value)){
            return null;
        }

        try {
            return new static($value);
        } catch (ValueObjectException) {
            return null;
        }
    }
}
