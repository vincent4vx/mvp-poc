<?php

namespace Quatrevieux\Mvp\Core\ValueObject;

use function htmlentities;

class DisplayStringValueObject extends StringValueObject
{
    final public function html(): string
    {
        return htmlentities($this->value);
    }
}
