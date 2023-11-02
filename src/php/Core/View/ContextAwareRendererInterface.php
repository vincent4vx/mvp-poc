<?php

namespace Quatrevieux\Mvp\Core\View;

interface ContextAwareRendererInterface extends RendererInterface
{
    public function withContext(ViewContext $context): static;
}
