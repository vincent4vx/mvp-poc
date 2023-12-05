<?php

namespace Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject;

use Quatrevieux\Mvp\Core\ValueObject\DisplayStringValueObject;
use Quatrevieux\Mvp\Core\ValueObject\InvalidValueException;

use function trim;

final class MessageContent extends DisplayStringValueObject
{
    protected function __construct(string $value)
    {
        $value = trim($value);

        if (strlen($value) < 1) {
            throw new InvalidValueException(self::class, 'Message content must not be empty');
        }

        parent::__construct($value);
    }
}
