<?php

namespace Quatrevieux\Mvp\App;

use Quatrevieux\Mvp\App\User\User;
use Quatrevieux\Mvp\Core\ComponentInterface;
use Quatrevieux\Mvp\Core\ViewContext;

class MenuBar implements ComponentInterface
{
    public function __construct(
        public readonly ?User $user
    ) {
    }

    public function id(): string
    {
        return 'menu-bar';
    }

    public function renderer(): string
    {
        return __DIR__ . '/../../template/menu-bar.html.php';
    }

    public static function createFromContext(ViewContext $context): static
    {
        return new self($context->user);
    }
}
