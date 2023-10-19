<?php

namespace Quatrevieux\Mvp\Core\ValueObject;

/**
 * @template T
 */
interface ValueObjectInterface
{
    /**
     * @return T
     */
    public function value(): mixed;

    public function __toString(): string;

    /**
     * @param T $value
     * @return static
     *
     * @throws InvalidPrimitiveTypeError if the type $value is not valid
     * @throws InvalidValueException if the value $value is not valid (e.g. out of range or invalid format)
     */
    public static function from(mixed $value): static;
    public static function tryFrom(mixed $value): ?static;
}
