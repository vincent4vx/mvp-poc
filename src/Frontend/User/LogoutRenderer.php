<?php

namespace Quatrevieux\Mvp\Frontend\User;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeRequest;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\SessionHandler;
use Quatrevieux\Mvp\Core\View\View;

class LogoutRenderer implements RendererInterface
{
    public function __construct(
        private readonly Router $router,
        private readonly SessionHandler $sessionHandler,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function render(View $view, object $data): string|ResponseInterface
    {
        $response = $this->responseFactory->createResponse(302)
            ->withHeader('Location', $this->router->generate(new HomeRequest()))
        ;

        if (!$data->user) {
            return $response;
        }

        return $this->sessionHandler->destroy($response, $data->user);
    }
}
