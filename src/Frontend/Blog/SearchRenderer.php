<?php

namespace Quatrevieux\Mvp\Frontend\Blog;

class SearchRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/Templates/search.html.php';
    }
}
