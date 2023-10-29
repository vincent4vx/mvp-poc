<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Core\View\View;

interface RendererInterface
{
    public function render(View $view, object $data): string|ResponseInterface|StreamingResponseInterface;
}
