<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;

use function in_array;

final class ModifiedUser extends AbstractUser
{
    /**
     * @var list<ModifiableUserField>
     */
    public readonly array $modifiedFields;

    public function __construct(
        UserId $id,
        Username $username,
        Password $password,
        Pseudo $pseudo,
        UserRolesSet $roles,
        ModifiableUserField ...$modifiedFields,
    )
    {
        parent::__construct($id, $username, $password, $pseudo, $roles);

        $this->modifiedFields = $modifiedFields;
    }

    public function saved(): User
    {
        return new User(
            id: $this->id,
            username: $this->username,
            password: $this->password,
            pseudo: $this->pseudo,
            roles: $this->roles,
        );
    }

    protected function addToModifiedFields(ModifiableUserField $field): array
    {
        if (in_array($field, $this->modifiedFields)) {
            return $this->modifiedFields;
        }

        return [...$this->modifiedFields, $field];
    }
}
