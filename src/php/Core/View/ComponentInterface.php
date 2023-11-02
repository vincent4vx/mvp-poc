<?php

namespace Quatrevieux\Mvp\Core\View;

interface ComponentInterface
{
    public function id(): string;

    public function renderer(): string|RendererInterface;

    public static function createFromContext(ViewContext $context): ?static;
}
