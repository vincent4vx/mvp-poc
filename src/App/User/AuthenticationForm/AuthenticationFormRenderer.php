<?php

namespace Quatrevieux\Mvp\App\User\AuthenticationForm;

use Quatrevieux\Mvp\App\AbstractArticleRenderer;

class AuthenticationFormRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/../../../../template/authentication.html.php';
    }
}
