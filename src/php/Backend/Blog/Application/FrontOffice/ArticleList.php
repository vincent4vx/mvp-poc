<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice;

use ArrayIterator;
use IteratorAggregate;
use Quatrevieux\Mvp\Backend\Blog\Domain\Article;
use Traversable;

/**
 * @implements IteratorAggregate<Article>
 */
final class ArticleList implements IteratorAggregate
{
    public function __construct(
        /**
         * @var Article[]
         */
        private readonly array $articles,
    ) {
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->articles);
    }
}
