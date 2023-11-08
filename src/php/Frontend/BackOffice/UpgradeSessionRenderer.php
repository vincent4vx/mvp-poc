<?php

namespace Quatrevieux\Mvp\Frontend\BackOffice;

use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\Security\Firewall;
use Quatrevieux\Mvp\Frontend\ApplicationRenderer;

class UpgradeSessionRenderer extends ApplicationRenderer
{
    public function __construct(Firewall $firewall, Router $router)
    {
        parent::__construct($firewall, $router, __DIR__ . '/Templates/upgrade-session.html.php');
    }
}
