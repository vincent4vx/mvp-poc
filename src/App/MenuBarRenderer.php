<?php

namespace Quatrevieux\Mvp\App;

use Quatrevieux\Mvp\Core\Renderer;
use Quatrevieux\Mvp\Core\Router;

class MenuBarRenderer extends Renderer
{
    public function __construct(Router $router)
    {
        parent::__construct($router, __DIR__ . '/../../template/menu-bar.html.php');
    }
}
