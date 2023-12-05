<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice;

use ArrayIterator;
use IteratorAggregate;
use Quatrevieux\Mvp\Backend\Blog\Domain\Article;
use Traversable;

/**
 * @implements IteratorAggregate<ArticleSummary>
 */
final class ArticleList implements IteratorAggregate
{
    public function __construct(
        /**
         * @var ArticleSummary[]
         */
        private readonly array $articles,
    ) {
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->articles);
    }

    public static function fromArticles(Article ...$articles): self
    {
        $summaries = [];

        foreach ($articles as $article) {
            $summaries[] = ArticleSummary::fromArticle($article);
        }

        return new self($summaries);
    }
}
