<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

use function ob_get_clean;
use function ob_start;

class Renderer implements RendererInterface
{
    public function __construct(
        private readonly Router $router,
        private readonly string $template,
    ) {
    }

    public function render(View $view, object $data): string
    {
        $template = $this->template;
        $renderer = $this;
        $context = $view->context();

        return (function () use ($template, $renderer, $view, $context): string {
            ob_start();
            require $template;
            return ob_get_clean();
        })->call($data);
    }

    public function url(object $query): string
    {
        return 'http://127.0.0.1:5000' . $this->router->generate($query);
    }
}
