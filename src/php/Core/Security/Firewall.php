<?php

namespace Quatrevieux\Mvp\Core\Security;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Core\QueryValidatorInterface;

class Firewall implements QueryValidatorInterface
{
    public function __construct(
        private readonly array $accessmap,
    ) {
    }

    public function validate(ServerRequestInterface $serverRequest, object $query): ?object
    {
        return match ($this->checkAccess($serverRequest, $query)) {
            AccessState::Authorized => $query,
            AccessState::AuthenticationRequired => new AuthenticationRequiredRequest($query),
            AccessState::NotEnoughPermissions => throw new \Exception('Not allowed'),
        };
    }

    public function hasAccess(ServerRequestInterface $serverRequest, object $query): bool
    {
        return $this->checkAccess($serverRequest, $query) === AccessState::Authorized;
    }

    private function checkAccess(ServerRequestInterface $serverRequest, object $query): AccessState
    {
        $validator = $this->accessmap[$query::class] ?? throw new \Exception('No validator found for ' . $query::class);

        return $validator($query, $serverRequest);
    }
}
