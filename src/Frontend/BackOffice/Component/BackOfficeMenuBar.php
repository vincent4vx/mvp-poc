<?php

namespace Quatrevieux\Mvp\Frontend\BackOffice\Component;

use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;
use Quatrevieux\Mvp\Core\View\ComponentInterface;
use Quatrevieux\Mvp\Core\View\ViewContext;

class BackOfficeMenuBar implements ComponentInterface
{
    public function __construct(
        public readonly ?AuthenticatedUser $user,
        public ?BackOfficeMenu $menu = null,
    ) {
    }

    public function id(): string
    {
        return 'menu-bar';
    }

    public function renderer(): string
    {
        return BackOfficeMenuBarRenderer::class;
    }

    public static function createFromContext(ViewContext $context): static
    {
        return new self($context->user);
    }
}
