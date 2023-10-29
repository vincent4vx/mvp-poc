<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home;

use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\ArticleList;

final class HomeResponse
{
    public function __construct(
        public readonly ArticleList $articles,
    ) {
    }
}
