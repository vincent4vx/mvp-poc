<?php

namespace Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject;

use Quatrevieux\Mvp\Core\ValueObject\InvalidPrimitiveTypeError;
use Quatrevieux\Mvp\Core\ValueObject\InvalidValueException;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;

use function is_int;

final class ChatMessageId implements ValueObjectInterface
{
    public function __construct(
        public readonly int $value,
    ) {
        if ($value < 1) {
            throw new InvalidValueException(self::class, 'ChatMessageId must be greater than 0');
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public static function from(mixed $value): static
    {
        if (!is_int($value)) {
            throw new InvalidPrimitiveTypeError(self::class, 'int', $value);
        }

        return new self($value);
    }

    public static function tryFrom(mixed $value): ?static
    {
        try {
            return new self((int) $value);
        } catch (InvalidPrimitiveTypeError | InvalidValueException) {
            return null;
        }
    }
}
