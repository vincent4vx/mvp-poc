<?php

namespace Quatrevieux\Mvp\Core\Security;

use Psr\Container\ContainerInterface;

class QueryAccessValidatorFactories
{
    final static public function anonymous(): AnonymousAccess
    {
        return new AnonymousAccess();
    }

    final static public function authenticated(mixed ...$roles): QueryAccessValidatorFactoryInterface
    {
        if (!$roles) {
            return new class implements QueryAccessValidatorFactoryInterface {
                public function create(ContainerInterface $container): QueryAccessValidatorInterface
                {
                    return $container->get(AuthenticatedAccess::class);
                }
            };
        }

        return new class($roles) implements QueryAccessValidatorFactoryInterface {
            public function __construct(
                protected readonly array $roles,
            ) {
            }

            public function create(ContainerInterface $container): QueryAccessValidatorInterface
            {
                return $container->get(AuthenticatedAccess::class)->withRoles($this->roles);
            }
        };
    }
}
