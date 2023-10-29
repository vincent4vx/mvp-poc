<?php

namespace Quatrevieux\Mvp\Frontend\Component;

use Quatrevieux\Mvp\Core\View\ComponentInterface;
use Quatrevieux\Mvp\Core\View\ViewContext;

class SearchBar implements ComponentInterface
{
    public function id(): string
    {
        return 'search-bar';
    }

    public function renderer(): string
    {
        return __DIR__ . '/Templates/search-bar.html.php';
    }

    public static function createFromContext(ViewContext $context): ?static
    {
        return null;
    }
}
