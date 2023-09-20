<?php

namespace Quatrevieux\Mvp\App;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Core\View;
use Quatrevieux\Mvp\Core\ViewContext;
use Quatrevieux\Mvp\Core\Renderer;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;

class LayoutRenderer implements RendererInterface
{
    private readonly Renderer $renderer;

    public function __construct(
        private readonly Router $router,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
    ) {
        $this->renderer = new Renderer($router, __DIR__.'/../../template/layout.html.php');
    }

    /**
     * @param CustomViewContext $data
     * @return string|ResponseInterface
     */
    public function render(View $view, object $data): string|ResponseInterface
    {
        if ($data->request->getHeaderLine('X-PJAX') === 'true') {
            return $this->responseFactory->createResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withBody($this->streamFactory->createStream(json_encode([
                    'content' => $data->content,
                    'title' => $data->title ?? 'My Blog',
                    'menuBar' => $view->renderResponse(new MenuBar($data->user))
                ])))
            ;
        }

        return $this->renderer->render($view, $data);
    }
}
