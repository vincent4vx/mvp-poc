<?php

namespace Quatrevieux\Mvp\Frontend\User\BackOffice;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersResponse;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\Helper\Button;
use Quatrevieux\Mvp\Core\View\Helper\Pagination;
use Quatrevieux\Mvp\Core\View\Renderer;
use Quatrevieux\Mvp\Core\View\RendererInterface;
use Quatrevieux\Mvp\Core\View\View;

use function json_encode;

class ListUsersRenderer implements RendererInterface
{
    private readonly Renderer $fullRenderer;
    private readonly Renderer $resultsRenderer;

    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly Router $router,
    ) {
        $this->fullRenderer = new Renderer($router, __DIR__ . '/Templates/list-users.html.php', $this);
        $this->resultsRenderer = new Renderer($router, __DIR__ . '/Templates/list-users-results.html.php', $this);
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

    public function pagination(ListUsersResponse $response): Pagination
    {
        $pagination = new Pagination($this->router, $response->request->withPage(...));

        $pagination->currentPage($response->page);
        $pagination->totalPages($response->pageCount);
        $pagination->maxPages(10);

        return $pagination;
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
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode([
                'users-list-results' => $this->resultsRenderer->render($view, $data),
                'users-list-pagination' => (string) $this->pagination($data),
            ])))
        ;
    }
}
