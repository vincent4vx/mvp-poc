<?php

namespace Quatrevieux\Mvp\App\Home;

use Quatrevieux\Mvp\App\AbstractArticleRenderer;

class ArticleListRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/../../../template/article-list.html.php';
    }
}
