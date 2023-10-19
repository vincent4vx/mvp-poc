<?php

namespace Quatrevieux\Mvp\App\Home;

use ArrayIterator;
use IteratorAggregate;
use Quatrevieux\Mvp\App\Article;
use Traversable;

/**
 * @implements IteratorAggregate<Article>
 */
final class ArticleList implements IteratorAggregate
{
    public function __construct(
        /**
         * @var list<Article>
         */
        private readonly array $articles,
    ) {
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->articles);
    }
}
