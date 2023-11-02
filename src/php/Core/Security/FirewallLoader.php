<?php

namespace Quatrevieux\Mvp\Core\Security;

use Closure;
use Psr\Container\ContainerInterface;

use function is_array;
use function is_callable;

class FirewallLoader
{
    public function __construct(
        protected readonly ContainerInterface $container,
    ) {
    }

    public function load(string $file): Firewall
    {
        $value = require $file;

        // @todo builder ?
        if ($value instanceof Closure) {
            $value = $value->call($this);
        }

        if (is_array($value)) {
            return $this->loadArray($value);
        }

        throw new \Exception('Invalid firewall configuration');
    }

    public function anonymous(): AnonymousAccess
    {
        return new AnonymousAccess();
    }

    public function authenticated(mixed... $roles): AuthenticatedAccess
    {
        /** @var AuthenticatedAccess $validator */
        $validator = $this->container->get(AuthenticatedAccess::class);

        if ($roles) {
            $validator = $validator->withRoles($roles);
        }

        return $validator;
    }

    private function loadArray(array $rules): Firewall
    {
        $accessmap = [];

        foreach ($rules as $query => $validator) {
            $accessmap[$query] = $this->loadValidator($validator);
        }

        return new Firewall($accessmap);
    }

    private function loadValidator(mixed $validator)
    {
        if (is_callable($validator)) {
            return $validator;
        }

        if (is_string($validator)) {
            return $this->container->get($validator);
        }

        throw new \Exception('Invalid validator');
    }
}
