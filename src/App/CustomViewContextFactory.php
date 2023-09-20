<?php

namespace Quatrevieux\Mvp\App;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\App\User\User;
use Quatrevieux\Mvp\Core\SessionBearerInterface;
use Quatrevieux\Mvp\Core\SessionHandler;
use Quatrevieux\Mvp\Core\ViewContext;
use Quatrevieux\Mvp\Core\ViewContextFactoryInterface;

class CustomViewContextFactory implements ViewContextFactoryInterface
{
    public function __construct(
        private readonly SessionHandler $sessionHandler,
    ) {
    }

    public function createContext(ServerRequestInterface $request, object $query, object $response): ViewContext
    {
        $context = new CustomViewContext($request, $query, $response);

        // Optimisation: do not resolve session if already resolved
        if ($query instanceof SessionBearerInterface) {
            $context->user = $query->session();
        } else {
            $context->user = $this->sessionHandler->resolve($request);
        }

        return $context;
    }
}
