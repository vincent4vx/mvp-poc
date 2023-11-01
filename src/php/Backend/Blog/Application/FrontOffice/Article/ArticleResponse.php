<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article;

use Quatrevieux\Mvp\Backend\Blog\Domain\Article;

final class ArticleResponse
{
    public function __construct(
        public readonly Article $article,
    ) {
    }
}
