<?php

namespace Quatrevieux\Mvp\App\ValueObject;

use Quatrevieux\Mvp\App\Search\SearchRequest;
use Quatrevieux\Mvp\Core\ValueObject\InvalidPrimitiveTypeError;
use Quatrevieux\Mvp\Core\ValueObject\InvalidValueException;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;

use function htmlentities;

final class ArticleTag implements ValueObjectInterface
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

    public function search(): SearchRequest
    {
        return SearchRequest::tag($this->value);
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
