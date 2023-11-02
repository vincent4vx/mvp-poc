<?php

namespace Quatrevieux\Mvp\Core\View\Extensions;

use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\Helper\Button;

trait RouterTrait
{
    private readonly Router $router;

    public function url(object|string $query): string
    {
        return $this->router->generate($query);
    }

    public function button(string $label): Button
    {
        return new Button($label, $this->router);
    }
}
