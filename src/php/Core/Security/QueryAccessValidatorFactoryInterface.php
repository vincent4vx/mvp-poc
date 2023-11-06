<?php

namespace Quatrevieux\Mvp\Core\Security;

use Psr\Container\ContainerInterface;

interface QueryAccessValidatorFactoryInterface
{
    public function create(ContainerInterface $container): QueryAccessValidatorInterface;
}
