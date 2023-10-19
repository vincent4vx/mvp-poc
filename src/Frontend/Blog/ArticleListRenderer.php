<?php

namespace Quatrevieux\Mvp\Frontend\Blog;

class ArticleListRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/Templates/article-list.html.php';
    }
}
