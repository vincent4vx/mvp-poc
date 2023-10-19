<?php

namespace Quatrevieux\Mvp\Backend\Blog\Article;

use Quatrevieux\Mvp\Backend\Blog\Article;

final class ArticleResponse
{
    public function __construct(
        public readonly Article $article,
    ) {
    }
}
