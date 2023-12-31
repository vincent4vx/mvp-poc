<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search;

use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\ArticleList;

class SearchResponse
{
    public function __construct(
        public readonly int $total,
        public readonly ArticleList $articles,
        public readonly array $tags,
        public readonly ?string $query = null,
        public readonly ?string $tag = null,
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
