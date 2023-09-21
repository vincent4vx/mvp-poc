<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Runner
{
    public function __construct(
        private readonly Router $router,
        private readonly QueryValidator $queryValidator,
        private readonly Dispatcher $dispatcher,
        private readonly View $view,
    ) {
    }

    public function run(ServerRequestInterface $serverRequest): ResponseInterface
    {
        $action = $this->router->resolve($serverRequest);
        $action = $this->queryValidator->validate($action);
        $result = $this->dispatcher->dispatch($action);

        return $this->view->response($result);
    }
}
