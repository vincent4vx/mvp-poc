<?php

namespace Quatrevieux\Mvp\Frontend\User\BackOffice;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersResponse;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\Renderer;
use Quatrevieux\Mvp\Core\View\View;

class ListUsersRenderer implements RendererInterface
{
    private readonly Renderer $fullRenderer;
    private readonly Renderer $resultsRenderer;

    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        Router $router,
    ) {
        $this->fullRenderer = new Renderer($router, __DIR__ . '/Templates/list-users.html.php');
        $this->resultsRenderer = new Renderer($router, __DIR__ . '/Templates/list-users-results.html.php');
    }

    /**
     * @param View $view
     * @param ListUsersResponse $data
     * @return string|ResponseInterface
     */
    public function render(View $view, object $data): string|ResponseInterface
    {
        if (!$data->request->ajax) {
            return $this->fullRenderer->render($view, $data);
        }

        return $this->responseFactory->createResponse(200)
            ->withHeader('Content-Type', 'text/html')
            ->withBody($this->streamFactory->createStream(
                $this->resultsRenderer->render($view, $data)
            ))
        ;
    }
}
