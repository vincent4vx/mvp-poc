<?php

namespace Quatrevieux\Mvp\Frontend\Component;

use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;
use Quatrevieux\Mvp\Core\View\ComponentInterface;
use Quatrevieux\Mvp\Core\View\ViewContext;

class MenuBar implements ComponentInterface
{
    public function __construct(
        public readonly ?AuthenticatedUser $user
    ) {
    }

    public function id(): string
    {
        return 'menu-bar';
    }

    public function renderer(): string
    {
        return __DIR__ . '/Templates/menu-bar.html.php';
    }

    public static function createFromContext(ViewContext $context): static
    {
        return new self($context->user);
    }
}
