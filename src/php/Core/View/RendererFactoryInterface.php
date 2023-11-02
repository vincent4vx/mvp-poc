<?php

namespace Quatrevieux\Mvp\Core\View;

interface RendererFactoryInterface
{
    public function forTemplate(string $template): RendererInterface;
}
