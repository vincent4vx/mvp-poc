<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;
use Quatrevieux\Mvp\Core\Bus\ProcessableCommand;

/**
 * @implements ProcessableCommand<UpdateUserResult>
 */
final class UpdateUser implements ProcessableCommand
{
    public function __construct(
        public readonly User $user,
        public readonly ?Pseudo $pseudo = null,
        public readonly ?Password $password = null,
        public readonly ?UserRolesSet $roles = null,
    ) {
    }

    public function process(mixed $response): UpdateUserResult
    {
        return $response;
    }
}
