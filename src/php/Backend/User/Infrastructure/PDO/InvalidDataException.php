<?php

namespace Quatrevieux\Mvp\Backend\User\Infrastructure\PDO;

class InvalidDataException extends \InvalidArgumentException
{
    public function __construct(
        public readonly InvalidDataErrorType $type,
        public readonly string $field,
        string $message,
    ) {
        parent::__construct($message);
    }
}
