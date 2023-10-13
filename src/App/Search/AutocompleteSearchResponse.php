<?php

namespace Quatrevieux\Mvp\App\Search;

class AutocompleteSearchResponse
{
    public function __construct(
        /**
         * @var array<\Quatrevieux\Mvp\App\Article>
         */
        public readonly array $articles,
    ) {
    }
}
