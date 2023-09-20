<?php

namespace Quatrevieux\Mvp\App\User\RegistrationForm;

use Quatrevieux\Mvp\App\AbstractArticleRenderer;

class RegistrationFormRenderer extends AbstractArticleRenderer
{
    static protected function template(): string
    {
        return __DIR__ . '/../../../../template/registration.html.php';
    }
}
