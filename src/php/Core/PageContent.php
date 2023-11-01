<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Core\View\ComponentInterface;
use Quatrevieux\Mvp\Core\View\View;
use Quatrevieux\Mvp\Core\View\ViewContext;

class PageContent implements ComponentInterface, RendererInterface
{
    public function __construct(
        public readonly string $content,
    ) {
    }

    public function id(): string
    {
        return 'page-content';
    }

    public function renderer(): RendererInterface
    {
        return $this;
    }

    public function render(View $view, object $data): string|ResponseInterface
    {
        return $this->content;
    }

    public static function createFromContext(ViewContext $context): static
    {
        return new self($context->content);
    }
}
