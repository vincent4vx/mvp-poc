<?php

namespace Quatrevieux\Mvp\Backend\Blog\ValueObject;

use Michelf\MarkdownInterface;
use Quatrevieux\Mvp\Core\ValueObject\InvalidPrimitiveTypeError;
use Quatrevieux\Mvp\Core\ValueObject\InvalidValueException;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;

use function htmlentities;
use function is_string;
use function substr;

final class ArticleContent implements ValueObjectInterface
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

    public function summary(int $length = 200): self
    {
        return new self(substr($this->value, 0, $length));
    }

    public function html(MarkdownInterface $markdown): string
    {
        return $markdown->transform(htmlentities($this->value));
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
        } catch (InvalidValueException) {
            return null;
        }
    }
}
