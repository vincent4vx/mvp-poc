<?php

namespace Quatrevieux\Mvp\Backend\Blog\ValueObject;

use ArrayIterator;
use IteratorAggregate;
use Quatrevieux\Mvp\Core\ValueObject\InvalidPrimitiveTypeError;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;
use Traversable;

use function explode;
use function implode;
use function is_array;
use function trim;

/**
 * @implements IteratorAggregate<ArticleTag>
 */
final class ArticleTags implements IteratorAggregate, ValueObjectInterface
{
    public readonly array $value;

    public function __construct(ArticleTag... $tags)
    {
        $this->value = $tags;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->value);
    }

    public function value(): array
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return implode(', ', $this->value);
    }

    public static function from(mixed $value): static
    {
        if (!is_array($value)) {
            throw new InvalidPrimitiveTypeError(self::class, 'array', $value);
        }

        $tags = [];

        foreach ($value as $tag) {
            $tags[] = ArticleTag::from($tag);
        }

        return new self(...$tags);
    }

    public static function tryFrom(mixed $value): ?static
    {
        if (!is_array($value)) {
            return null;
        }

        $tags = [];

        foreach ($value as $tag) {
            $tag = ArticleTag::tryFrom($tag);

            if ($tag) {
                $tags[] = $tag;
            }
        }

        return new self(...$tags);
    }

    public static function fromString(string $value): static
    {
        $tags = [];

        foreach (explode(',', $value) as $tag) {
            $tag = ArticleTag::tryFrom(trim($tag));

            if ($tag) {
                $tags[] = $tag;
            }
        }

        return new self(...$tags);
    }
}
