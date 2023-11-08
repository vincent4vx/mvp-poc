<?php

namespace Quatrevieux\Mvp\Backend\BackOffice\Security;

use Quatrevieux\Mvp\Backend\User\Domain\User;

final class UpgradeSessionResponse
{
    public function __construct(
        public readonly User $user,
        public readonly string $target,
        public readonly ?string $error = null,
    ) {
    }
}
