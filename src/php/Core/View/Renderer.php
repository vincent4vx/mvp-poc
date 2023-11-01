<?php

namespace Quatrevieux\Mvp\Core\View;

use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;

use Quatrevieux\Mvp\Core\View\Helper\Button;

use function htmlentities;
use function ob_get_clean;
use function ob_start;
use function sprintf;

class Renderer implements RendererInterface
{
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

    // @todo move to other class
    public function url(object|string $query): string
    {
        return $this->router->generate($query);
    }

    public function button(string $label): Button
    {
        return new Button($label, $this->router);
    }
}
