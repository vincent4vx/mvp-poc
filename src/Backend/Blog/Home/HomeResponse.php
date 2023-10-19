<?php

namespace Quatrevieux\Mvp\Backend\Blog\Home;

final class HomeResponse
{
    public function __construct(
        public readonly ArticleList $articles,
    ) {
    }
}
