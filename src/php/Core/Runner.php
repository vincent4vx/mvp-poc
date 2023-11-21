<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Core\View\View;

class Runner
{
    public function __construct(
        private readonly Router $router,
        private readonly QueryValidator $queryValidator,
        private readonly Dispatcher $dispatcher,
        private readonly View $view,
    ) {
    }

    public function run(ServerRequestInterface $serverRequest): ResponseInterface|StreamingResponseInterface
    {
        try {
            $action = $this->router->resolve($serverRequest);
            $action = $this->queryValidator->validate($action);
            $result = $this->dispatcher->dispatch($action);

            return $this->view->response($result);
        } catch (\Throwable $e) {
            // @todo better handling of errors
            $action = new ErroredRequest($serverRequest, $action?->query ?? null, $e);
            $result = $this->dispatcher->dispatch(new RoutedQuery($serverRequest, $action));

            return $this->view->response($result);
        }
    }
}
