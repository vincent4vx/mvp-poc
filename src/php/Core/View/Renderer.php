<?php

namespace Quatrevieux\Mvp\Core\View;

use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\Extensions\RouterTrait;

use function ob_get_clean;
use function ob_start;

class Renderer implements RendererInterface
{
    use RouterTrait;

    public function __construct(
        private readonly Router $router,
        private readonly string $template,
        private readonly ?RendererInterface $parent = null,
    ) {
    }

    public function render(View $view, object $data): string
    {
        $template = $this->template;
        $renderer = $this->parent ?? $this;
        $context = $view->context();

        return (function () use ($template, $renderer, $view, $context): string {
            ob_start();
            require $template;
            return ob_get_clean();
        })->call($data);
    }
}
