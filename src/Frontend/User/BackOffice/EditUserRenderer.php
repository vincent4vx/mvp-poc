<?php

namespace Quatrevieux\Mvp\Frontend\User\BackOffice;

use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\Renderer;

class EditUserRenderer extends Renderer
{
    public function __construct(Router $router)
    {
        parent::__construct($router, __DIR__ . '/Templates/edit-user.html.php');
    }
}
