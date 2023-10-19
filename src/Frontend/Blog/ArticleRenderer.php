<?php

namespace Quatrevieux\Mvp\Frontend\Blog;

class ArticleRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/Templates/article.html.php';
    }
}
