<?php

namespace Quatrevieux\Mvp\Frontend\User;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Backend\Blog\Home\HomeRequest;
use Quatrevieux\Mvp\Backend\User\Authentication\AuthenticationResponse;
use Quatrevieux\Mvp\Backend\User\AuthenticationForm\AuthenticationFormResponse;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\SessionHandler;
use Quatrevieux\Mvp\Core\View;

class AuthenticationRenderer implements RendererInterface
{
    public function __construct(
        private readonly Router $router,
        private readonly SessionHandler $sessionHandler,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    /**
     * @param AuthenticationResponse $data
     * @return string|ResponseInterface
     */
    public function render(View $view, object $data): string|ResponseInterface
    {
        if (!$data->success) {
            return $view->renderResponse(new AuthenticationFormResponse('Invalid user'));
        }

        $response = $this->responseFactory->createResponse(302)
            ->withHeader('Location', $this->router->generate(new HomeRequest()))
        ;

        return $this->sessionHandler->write($response, $data->user);
    }
}
