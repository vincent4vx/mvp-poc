<?php

namespace Quatrevieux\Mvp\App\User\Profile;

use Quatrevieux\Mvp\App\User\ValueObject\Pseudo;
use Quatrevieux\Mvp\App\User\ValueObject\Username;

class ProfileResponse
{
    public function __construct(
        public readonly Username $name,
        public readonly Pseudo $pseudo,
    ) {
    }
}
