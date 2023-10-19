<?php

namespace Quatrevieux\Mvp\Backend\User\Profile;

use Quatrevieux\Mvp\Backend\User\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\ValueObject\Username;

class ProfileResponse
{
    public function __construct(
        public readonly Username $name,
        public readonly Pseudo $pseudo,
    ) {
    }
}
