<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search;

class AutocompleteSearchResponse
{
    public function __construct(
        /**
         * @var array<\Quatrevieux\Mvp\Backend\Blog\Domain\Article>
         */
        public readonly array $articles,
    ) {
    }
}
