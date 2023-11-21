<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

use DateTimeInterface;
use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;

abstract class AbstractUser
{
    public function __construct(
        public readonly UserId $id,
        public readonly Username $username,
        public readonly Password $password,
        public readonly Pseudo $pseudo,
        public readonly UserRolesSet $roles,
    ) {
    }

    public function withPassword(Password $password): ModifiedUser|static
    {
        if ($this->password->value === $password->value) {
            return $this;
        }

        return new ModifiedUser(
            $this->id,
            $this->username,
            $password,
            $this->pseudo,
            $this->roles,
            ...$this->addToModifiedFields(ModifiableUserField::Password),
        );
    }

    public function withPseudo(Pseudo $pseudo): ModifiedUser|static
    {
        if ($this->pseudo->value === $pseudo->value) {
            return $this;
        }

        return new ModifiedUser(
            $this->id,
            $this->username,
            $this->password,
            $pseudo,
            $this->roles,
            ...$this->addToModifiedFields(ModifiableUserField::Pseudo),
        );
    }

    public function withRoles(UserRolesSet $roles): ModifiedUser|static
    {
        if ($this->roles->value === $roles->value) {
            return $this;
        }

        return new ModifiedUser(
            $this->id,
            $this->username,
            $this->password,
            $this->pseudo,
            $roles,
            ...$this->addToModifiedFields(ModifiableUserField::Roles),
        );
    }

    abstract protected function addToModifiedFields(ModifiableUserField $field): array;
}
