<?php

namespace Quatrevieux\Mvp\App\User\Authentication;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\App\Home\HomeRequest;
use Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRequest;
use Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormResponse;
use Quatrevieux\Mvp\Core\SessionHandler;
use Quatrevieux\Mvp\Core\View;
use Quatrevieux\Mvp\Core\ViewContext;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;

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
