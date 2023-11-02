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

    public function validate(ServerRequestInterface $serverRequest, object $query): void
    {
        if (!$this->hasAccess($serverRequest, $query)) {
            throw new \Exception('Access denied');
        }
    }

    public function hasAccess(ServerRequestInterface $serverRequest, object $query): bool
    {
        $validator = $this->accessmap[$query::class] ?? throw new \Exception('No validator found for ' . $query::class);

        return $validator($query, $serverRequest);
    }
}
