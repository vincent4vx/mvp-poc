<?php

namespace Quatrevieux\Mvp\Frontend\BackOffice\Component;

use Quatrevieux\Mvp\Core\View\ComponentInterface;
use Quatrevieux\Mvp\Core\View\ViewContext;

class BackOfficeSideBar implements ComponentInterface
{
    public function __construct(
        public ?BackOfficeMenuItem $menu = null,
    ) {
    }

    public function id(): string
    {
        return 'side-bar';
    }

    public function renderer(): string
    {
        return BackOfficeSideBarRenderer::class;
    }

    public static function createFromContext(ViewContext $context): static
    {
        return new self();
    }
}
