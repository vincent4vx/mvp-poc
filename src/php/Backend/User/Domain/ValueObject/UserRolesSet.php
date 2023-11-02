<?php

namespace Quatrevieux\Mvp\Backend\User\Domain\ValueObject;

use Quatrevieux\Mvp\Backend\User\Domain\UserRole;
use Quatrevieux\Mvp\Core\ValueObject\InvalidPrimitiveTypeError;
use Quatrevieux\Mvp\Core\ValueObject\ValueObjectInterface;

use function array_map;
use function implode;
use function is_numeric;

final class UserRolesSet implements ValueObjectInterface
{
    public function __construct(
        public readonly int $value,
    ) {
    }

    public function is(UserRole $role): bool
    {
        return ($this->value & $role->value) === $role->value;
    }

    public function toArray(): array
    {
        $roles = [];

        foreach (UserRole::cases() as $role) {
            if (($this->value & $role->value) === $role->value) {
                $roles[] = $role;
            }
        }

        return $roles;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return implode(', ', array_map(fn (UserRole $role) => $role->label(), $this->toArray()));
    }

    public static function from(mixed $value): static
    {
        if (!\is_int($value)) {
            throw new InvalidPrimitiveTypeError(self::class, 'int', $value);
        }

        return new static($value);
    }

    public static function tryFrom(mixed $value): ?static
    {
        if (!is_numeric($value)) {
            return null;
        }

        return new static($value);
    }

    public static function fromRoles(UserRole ...$role): static
    {
        $value = 0;

        foreach ($role as $r) {
            $value |= $r->value;
        }

        return new static($value);
    }
}
