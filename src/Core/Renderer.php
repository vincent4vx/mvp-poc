<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

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

    public function layout(ServerRequestInterface $serverRequest, object $query, object $response, string $content): ?ViewContext
    {
        return new ViewContext(
            request: $serverRequest,
            query: $query,
            response: $response,
        );
    }

    public function url(object $query): string
    {
        return $this->router->generate($query);
    }
}
