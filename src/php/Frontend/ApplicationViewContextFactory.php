<?php

namespace Quatrevieux\Mvp\Frontend;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Backend\BackOffice\BackOfficeRequest;
use Quatrevieux\Mvp\Core\SessionBearerInterface;
use Quatrevieux\Mvp\Core\SessionHandler;
use Quatrevieux\Mvp\Core\View\ViewContextFactoryInterface;
use Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeViewContext;

class ApplicationViewContextFactory implements ViewContextFactoryInterface
{
    public function __construct(
        private readonly SessionHandler $sessionHandler,
    ) {
    }

    public function createContext(ServerRequestInterface $request, object $query, object $response): ApplicationViewContext
    {
        $context = $query instanceof BackOfficeRequest
            ? new BackOfficeViewContext($request, $query, $response)
            : new FrontOfficeViewContext($request, $query, $response)
        ;

        // Optimisation: do not resolve session if already resolved
        if ($query instanceof SessionBearerInterface) {
            $context->user = $query->session();
        } else {
            $context->user = $this->sessionHandler->resolve($request);
        }

        return $context;
    }
}
