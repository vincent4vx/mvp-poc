<?php

namespace Quatrevieux\Mvp\Frontend\BackOffice\Component;

use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\Renderer;
use Quatrevieux\Mvp\Core\View\View;

class BackOfficeMenuBarRenderer extends Renderer
{
    public function __construct(Router $router, private readonly BackOfficeMenu $menu)
    {
        parent::__construct($router, __DIR__ . '/Templates/menu-bar.html.php');
    }

    /**
     * @param View $view
     * @param BackOfficeMenuBar $data
     * @return string
     */
    public function render(View $view, object $data): string
    {
        $data->menu ??= $this->menu;

        return parent::render($view, $data); // TODO: Change the autogenerated stub
    }
}
