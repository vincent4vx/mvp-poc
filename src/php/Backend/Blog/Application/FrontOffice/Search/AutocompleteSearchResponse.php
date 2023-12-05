<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search;

use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\ArticleList;

class AutocompleteSearchResponse
{
    public function __construct(
        public readonly ArticleList $articles,
    ) {
    }
}
