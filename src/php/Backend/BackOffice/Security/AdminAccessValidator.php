<?php

namespace Quatrevieux\Mvp\Backend\BackOffice\Security;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;
use Quatrevieux\Mvp\Core\QueryValidatorInterface;

use Quatrevieux\Mvp\Core\SessionBearerInterface;

use Quatrevieux\Mvp\Core\SessionHandler;
use Throwable;

use function array_fill_keys;

class AdminAccessValidator implements QueryValidatorInterface
{
    private readonly array $queries;

    public function __construct(
        private readonly SessionHandler $sessionHandler,
        array $queries
    ) {
        $this->queries = array_fill_keys($queries, true);
    }

    public function validate(ServerRequestInterface $serverRequest, object $query): ?object
    {
        if ($query instanceof UpgradeSessionRequest || empty($this->queries[$query::class])) {
            return null;
        }

        $session = $this->getSession($query, $serverRequest);

        if (!$session instanceof AuthenticatedUser) {
            throw new \LogicException('Session required');
        }

        if ($session->isAdminSession()) {
            return null;
        }

        return UpgradeSessionRequest::create($query, $session);
    }

    // @todo factorize this code with AuthenticatedAccess
    private function getSession(object $query, ServerRequestInterface $serverRequest): ?object
    {
        if ($query instanceof SessionBearerInterface) {
            try {
                $session = $query->session();

                if ($session) {
                    return $session;
                }
            } catch (Throwable) {
                // Ignore potential type errors
            }
        }

        return $this->sessionHandler->resolve($serverRequest);
    }
}

