<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RendererInterface
{
    public function render(View $view, object $data): string|ResponseInterface|StreamingResponseInterface;
}
