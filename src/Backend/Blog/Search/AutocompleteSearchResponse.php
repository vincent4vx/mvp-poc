<?php

namespace Quatrevieux\Mvp\Backend\Blog\Search;

class AutocompleteSearchResponse
{
    public function __construct(
        /**
         * @var array<\Quatrevieux\Mvp\Backend\Blog\Article>
         */
        public readonly array $articles,
    ) {
    }
}
