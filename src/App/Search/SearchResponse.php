<?php

namespace Quatrevieux\Mvp\App\Search;

class SearchResponse
{
    public function __construct(
        public readonly int $total,
        /**
         * @var array<\Quatrevieux\Mvp\App\Article>
         */
        public readonly array $articles,
        public array $tags,
        public ?string $query = null,
        public ?string $tag = null,
    ) {
    }

    public function empty(): bool
    {
        return $this->total === 0;
    }

    public function tagActive(string $tag): bool
    {
        return $this->tag && strtolower(trim($this->tag)) === $tag;
    }
}
