<?php

namespace Quatrevieux\Mvp\Core\ValueObject;

use JsonSerializable;

use function is_string;

abstract class StringValueObject implements ValueObjectInterface, JsonSerializable
{
    protected function __construct(
        public readonly string $value,
    ) {
    }

    final public function jsonSerialize(): string
    {
        return $this->value;
    }

    final public function value(): string
    {
        return $this->value;
    }

    final public function __toString(): string
    {
        return $this->value;
    }

    public static function from(mixed $value): static
    {
        if (!is_string($value)) {
            throw new InvalidPrimitiveTypeError(static::class, 'string', $value);
        }

        return new static($value);
    }

    public static function tryFrom(mixed $value): ?static
    {
        try {
            return static::from($value);
        } catch (ValueObjectException) {
            return null;
        }
    }
}
