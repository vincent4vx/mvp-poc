<?php

namespace Quatrevieux\Mvp\App\Chat\Send;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\App\Chat\Show\ShowChatRequest;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View;

class SendMessageRenderer implements RendererInterface
{
    public function __construct(
        private readonly Router $router,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function render(View $view, object $data): ResponseInterface
    {
        return $this->responseFactory->createResponse(302)
            ->withHeader('Location', $this->router->generate(new ShowChatRequest()))
        ;
    }
}
