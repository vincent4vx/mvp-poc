<?php

namespace Quatrevieux\Mvp\Frontend;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\ComponentInterface;
use Quatrevieux\Mvp\Core\View\Renderer;
use Quatrevieux\Mvp\Core\View\View;

use function base64_encode;
use function hash_file;
use function sprintf;

class LayoutRenderer implements RendererInterface
{
    private readonly Renderer $renderer;
    /**
     * @todo should be cached & depend on layout file
     * @var list<class-string<ComponentInterface>>|null
     */
    private ?array $components = null;

    public function __construct(
        private readonly Router $router,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly string $assetsUrl,
        private readonly string $template,
    ) {
        $this->renderer = new Renderer($router, $this->template, $this);
    }

    public function asset(string $path): string
    {
        return $this->assetsUrl.'/'.$path;
    }

    public function css(string $path): string
    {
        // @todo back asset path at constructor
        return sprintf(
            '<link href="%s" rel="stylesheet" crossorigin="anonymous" integrity="sha256-%s" />',
            $this->asset($path),
            base64_encode(hash_file('sha256', __DIR__ . '/../../public/assets/' . $path, true))
        );
    }

    public function url(object $request): string
    {
        return $this->router->generate($request);
    }

    /**
     * @param ApplicationViewContext $data
     * @return string|ResponseInterface
     */
    public function render(View $view, object $data): string|ResponseInterface
    {
        if ($data->ajax) {
            return $data->content;
        }

        if ($data->request->getHeaderLine('X-PJAX') === 'true') {
            // @todo store in cache
            if ($this->components === null) {
                $this->renderer->render($view, $data);
                $this->components = $data->components;
            }

            $components = [];

            foreach ($this->components as $componentClass) {
                $component = $componentClass::createFromContext($data);

                if ($component) {
                    $components[] = $component;
                }
            }

            $body = $data->export();
            $body['layout'] = md5_file($this->template);

            foreach ($components as $component) {
                $body[$component->id()] = $view->renderComponent($component);
            }

            return $this->responseFactory->createResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('Cache-Control', 'no-cache')
                ->withHeader('Vary', 'X-PJAX')
                ->withBody($this->streamFactory->createStream(json_encode($body)))
            ;
        }

        $content = $this->renderer->render($view, $data);

        if ($this->components === null) {
            $this->components = $data->components;
        }

        return $content;
    }
}
