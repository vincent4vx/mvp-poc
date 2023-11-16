<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;
use Quatrevieux\Mvp\Core\Bus\ProcessableCommand;

/**
 * @implements ProcessableCommand<CreateUserResult>
 */
final class CreateUser implements ProcessableCommand
{
    public function __construct(
        public readonly Username $username,
        public readonly Pseudo $pseudo,
        public readonly Password $password,
        public readonly UserRolesSet $roles = new UserRolesSet(0),
    ) {
    }

    public function process(mixed $response): CreateUserResult
    {
        return $response;
    }
}
