<?php

namespace Quatrevieux\Mvp\Frontend\User\BackOffice;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Delete\DeleteUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersRequest;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\View;

class DeleteUserRenderer implements RendererInterface
{
    public function __construct(
        private readonly Router $router,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    /**
     * @param View $view
     * @param DeleteUserRequest $data
     * @return string|ResponseInterface
     */
    public function render(View $view, object $data): string|ResponseInterface
    {
        return $this->responseFactory->createResponse(302)
            ->withAddedHeader('Location', $this->router->generate(new ListUsersRequest()))
        ;
    }
}
