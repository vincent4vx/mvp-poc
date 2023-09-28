<?php

namespace Quatrevieux\Mvp\App;

use Quatrevieux\Mvp\Core\ComponentInterface;
use Quatrevieux\Mvp\Core\ViewContext;

class SearchBar implements ComponentInterface
{
    public function id(): string
    {
        return 'search-bar';
    }

    public function renderer(): string
    {
        return __DIR__ . '/../../template/search-bar.html.php';
    }

    public static function createFromContext(ViewContext $context): ?static
    {
        return null;
    }
}
