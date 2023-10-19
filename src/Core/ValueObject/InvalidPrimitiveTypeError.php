<?php

namespace Quatrevieux\Mvp\Core\ValueObject;

use function gettype;
use function sprintf;

class InvalidPrimitiveTypeError extends \TypeError implements ValueObjectException
{
    public function __construct(string $valueObjectClass, string $expected, mixed $value)
    {
        parent::__construct(sprintf(
            'Invalid primitive type for %s. Expected %s, got %s',
            $valueObjectClass,
            $expected,
            get_debug_type($value)
        ));
    }
}
