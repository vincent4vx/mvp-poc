<?php

namespace Quatrevieux\Mvp\Frontend\User;

use Quatrevieux\Mvp\Frontend\Blog\AbstractArticleRenderer;

class AuthenticationFormRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/Templates/authentication.html.php';
    }
}
