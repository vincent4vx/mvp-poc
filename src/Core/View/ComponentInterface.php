<?php

namespace Quatrevieux\Mvp\Core\View;

use Quatrevieux\Mvp\Core\RendererInterface;

interface ComponentInterface
{
    public function id(): string;

    public function renderer(): string|RendererInterface;

    public static function createFromContext(ViewContext $context): ?static;
}
