<?php

namespace Quatrevieux\Mvp\Frontend\Blog;

class HomeRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/Templates/home.html.php';
    }
}
