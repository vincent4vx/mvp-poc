<?php

namespace Quatrevieux\Mvp\App\Home;

use Quatrevieux\Mvp\App\Article;

final class HomeResponse
{
    public function __construct(
        /**
         * @var array<Article>
         */
        public readonly array $articles,
    ) {
    }
}
