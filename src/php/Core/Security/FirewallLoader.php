<?php

namespace Quatrevieux\Mvp\Core\Security;

use Closure;
use Psr\Container\ContainerInterface;

use function is_array;
use function is_callable;
use function is_string;

class FirewallLoader extends QueryAccessValidatorFactories
{
    public function __construct(
        protected readonly ContainerInterface $container,
    ) {
    }

    public function load(string|array $value): Firewall
    {
        if (is_string($value)) {
            $value = require $value;
        }

        // @todo builder ?
        if ($value instanceof Closure) {
            $value = $value->call($this);
        }

        if (is_array($value)) {
            return $this->loadArray($value);
        }

        throw new \Exception('Invalid firewall configuration');
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

        if ($validator instanceof QueryAccessValidatorFactoryInterface) {
            return $validator->create($this->container);
        }

        throw new \Exception('Invalid validator');
    }
}
