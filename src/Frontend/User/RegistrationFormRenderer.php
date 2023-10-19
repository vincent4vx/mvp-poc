<?php

namespace Quatrevieux\Mvp\Frontend\User;

use Quatrevieux\Mvp\Frontend\Blog\AbstractArticleRenderer;

class RegistrationFormRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/Templates/registration.html.php';
    }
}
