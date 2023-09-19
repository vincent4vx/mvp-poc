<?php

namespace Quatrevieux\Mvp\App;

final class Article
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $content,
        public readonly \DateTimeImmutable $createdAt,
        public readonly array $tags,
    ) {
    }
}
