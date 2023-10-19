<?php

namespace Quatrevieux\Mvp\Backend\Blog\ValueObject;

use Quatrevieux\Mvp\Backend\Blog\Article\ArticleRequest;
use Quatrevieux\Mvp\Core\ValueObject\InvalidPrimitiveTypeError;
use Quatrevieux\Mvp\Core\ValueObject\InvalidValueException;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;

final class ArticleId implements ValueObjectInterface
{
    public function __construct(
        public readonly int $value,
    ) {
        if ($value < 1) {
            throw new InvalidValueException(self::class, 'invalid id');
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

    public function toRequest(): ArticleRequest
    {
        return ArticleRequest::create($this->value);
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
        if (!is_scalar($value)) {
            return null;
        }

        try {
            return self::from((int) $value);
        } catch (InvalidValueException) {
            return null;
        }
    }
}
