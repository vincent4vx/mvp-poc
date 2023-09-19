<?php

namespace Quatrevieux\Mvp\App\Article;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\App\AbstractArticleRenderer;
use Quatrevieux\Mvp\App\CustomViewContext;
use Quatrevieux\Mvp\Core\ViewContext;
use Quatrevieux\Mvp\Core\Router;

class ArticleRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/../../../template/article.html.php';
    }
}
