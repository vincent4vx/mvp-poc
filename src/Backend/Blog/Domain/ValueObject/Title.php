<?php

namespace Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject;

use Quatrevieux\Mvp\Core\ValueObject\InvalidPrimitiveTypeError;
use Quatrevieux\Mvp\Core\ValueObject\InvalidValueException;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectException;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;

use function htmlentities;
use function is_string;

final class Title implements ValueObjectInterface
{
    public function __construct(
        public readonly string $value,
    ) {
        // @todo check charset
        if (!$value) {
            throw new InvalidValueException(self::class, 'empty string');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function html(): string
    {
        return htmlentities($this->value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function from(mixed $value): static
    {
        if (!is_string($value)) {
            throw new InvalidPrimitiveTypeError(self::class, 'string', $value);
        }

        return new self($value);
    }

    public static function tryFrom(mixed $value): ?static
    {
        try {
            return self::from($value);
        } catch (ValueObjectException) {
            return null;
        }
    }
}
