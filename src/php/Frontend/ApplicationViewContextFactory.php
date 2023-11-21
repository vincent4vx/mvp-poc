<?php

namespace Quatrevieux\Mvp\Frontend;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Backend\BackOffice\BackOfficeRequest;
use Quatrevieux\Mvp\Core\ErroredRequest;
use Quatrevieux\Mvp\Core\QueryDecoratorInterface;
use Quatrevieux\Mvp\Core\Security\AuthenticationRequiredRequest;
use Quatrevieux\Mvp\Core\SessionBearerInterface;
use Quatrevieux\Mvp\Core\SessionHandler;
use Quatrevieux\Mvp\Core\View\ViewContextFactoryInterface;
use Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeViewContext;

use function array_fill_keys;

class ApplicationViewContextFactory implements ViewContextFactoryInterface
{
    private readonly array $backOfficeQueries;

    public function __construct(
        private readonly SessionHandler $sessionHandler,
        array $backOfficeQueries,
    ) {
        $this->backOfficeQueries = array_fill_keys($backOfficeQueries, true);
    }

    public function createContext(ServerRequestInterface $request, object $query, object $response): ApplicationViewContext
    {
        $actualQuery = $query instanceof QueryDecoratorInterface ? $query->previousQuery() : $query;
        $actualQuery ??= $query;

        $context = isset($this->backOfficeQueries[$actualQuery::class])
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
