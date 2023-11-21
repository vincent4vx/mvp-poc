<?php

namespace Quatrevieux\Mvp\Frontend\User\BackOffice;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit\EditUserResponse;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save\SaveUserResponse;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\RendererInterface;
use Quatrevieux\Mvp\Core\View\View;

class SaveUserRenderer implements RendererInterface
{
    public function __construct(
        private readonly Router $router,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    /**
     * @param View $view
     * @param SaveUserResponse $data
     * @return string|ResponseInterface
     */
    public function render(View $view, object $data): string|ResponseInterface
    {
        if ($data->success) {
            return $this->responseFactory->createResponse(302)
                ->withAddedHeader('Location', $this->router->generate(new ListUsersRequest()))
            ;
        }

        return $view->renderResponse(new EditUserResponse(
            $data->user,
            $data->request->pseudo,
            errors: $data->errors,
            globalError: $data->globalError,
        ));
    }
}
