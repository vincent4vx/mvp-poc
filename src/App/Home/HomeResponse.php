<?php

namespace Quatrevieux\Mvp\App\Home;

final class HomeResponse
{
    public function __construct(
        public readonly ArticleList $articles,
    ) {
    }
}
