<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

interface QueryValidatorInterface
{
    public function validate(ServerRequestInterface $serverRequest, object $query): void;
}
