<?php

namespace Quatrevieux\Mvp\Core\View;

use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Core\StreamingResponseInterface;

interface RendererInterface
{
    public function render(View $view, object $data): string|ResponseInterface|StreamingResponseInterface;
}
