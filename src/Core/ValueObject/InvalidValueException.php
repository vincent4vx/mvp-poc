<?php

namespace Quatrevieux\Mvp\Core\ValueObject;

class InvalidValueException extends \InvalidArgumentException implements ValueObjectException
{
    public function __construct(string $valueObjectClass, string $reason)
    {
        parent::__construct(sprintf(
            'Invalid value for %s: %s',
            $valueObjectClass,
            $reason
        ));
    }
}
