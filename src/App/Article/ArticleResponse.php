<?php

namespace Quatrevieux\Mvp\App\Article;

use Quatrevieux\Mvp\App\Article;

final class ArticleResponse
{
    public function __construct(
        public readonly Article $article,
    ) {
    }
}
