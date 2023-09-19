<?php

namespace Quatrevieux\Mvp\App\Search;

use Quatrevieux\Mvp\App\AbstractArticleRenderer;

class SearchRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/../../../template/search.html.php';
    }
}
