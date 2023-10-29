<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Profile;

use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;

class ProfileResponse
{
    public function __construct(
        public readonly Username $name,
        public readonly Pseudo $pseudo,
    ) {
    }
}
