<?php

namespace Quatrevieux\Mvp\Frontend\BackOffice;

use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\Renderer;

class HomeRenderer extends Renderer
{
    public function __construct(Router $router)
    {
        parent::__construct($router, __DIR__ . '/Templates/home.html.php');
    }
}
