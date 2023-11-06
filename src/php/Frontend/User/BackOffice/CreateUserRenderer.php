<?php

namespace Quatrevieux\Mvp\Frontend\User\BackOffice;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserFormResponse;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserResponse;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersRequest;
use Quatrevieux\Mvp\Backend\User\Domain\UserRole;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\RendererInterface;
use Quatrevieux\Mvp\Core\View\View;

use function array_filter;
use function array_map;

class CreateUserRenderer implements RendererInterface
{
    public function __construct(
        private readonly Router $router,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    /**
     * @param View $view
     * @param CreateUserResponse $data
     * @return string|ResponseInterface
     */
    public function render(View $view, object $data): string|ResponseInterface
    {
        if ($data->success) {
            return $this->responseFactory->createResponse(302)
                ->withAddedHeader('Location', $this->router->generate(new ListUsersRequest()))
            ;
        }

        return $view->renderResponse(new CreateUserFormResponse(
            $data->request->username,
            $data->request->pseudo,
            array_filter(array_map(UserRole::tryFrom(...), $data->request->roles)),
            errors: $data->errors
        ));
    }
}
