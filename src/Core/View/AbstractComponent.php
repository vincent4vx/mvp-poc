<?php

namespace Quatrevieux\Mvp\Core\View;

use function preg_replace;
use function strrchr;
use function strtolower;
use function substr;

abstract class AbstractComponent implements ComponentInterface
{
    public function id(): string
    {
        // ID if the simple name of the class, transformed to kebab-case
        $id = static::class;
        $id = substr(strrchr($id, '\\'), 1); // Remove namespace
        $id = preg_replace('/(?<!^)[A-Z]/', '-$0', $id); // CamelCase to kebab-case

        return strtolower($id);
    }

    public static function createFromContext(ViewContext $context): ?static
    {
        return new static();
    }
}
