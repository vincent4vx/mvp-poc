<?php

namespace Quatrevieux\Mvp\Core\View\Extensions;

use LogicException;
use Quatrevieux\Mvp\Core\Security\Firewall;
use Quatrevieux\Mvp\Core\View\ViewContext;

trait SecurityTrait
{
    private readonly Firewall $firewall;
    private ?ViewContext $context = null;

    public function hasAccess(object $query): bool
    {
        $serverRequest = $this->context?->request ?? throw new LogicException('Context not set');

        return $this->firewall->hasAccess($serverRequest, $query);
    }
}
