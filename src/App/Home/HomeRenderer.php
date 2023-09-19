<?php

namespace Quatrevieux\Mvp\App\Home;

use Quatrevieux\Mvp\App\AbstractArticleRenderer;
use Quatrevieux\Mvp\Core\Router;

class HomeRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/../../../template/home.html.php';
    }
}
