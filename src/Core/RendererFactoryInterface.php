<?php

namespace Quatrevieux\Mvp\Core;

interface RendererFactoryInterface
{
    public function forTemplate(string $template): RendererInterface;
}
