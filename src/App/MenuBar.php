<?php

namespace Quatrevieux\Mvp\App;

use Quatrevieux\Mvp\App\User\User;

class MenuBar
{
    public function __construct(
        public readonly ?User $user
    ) {
    }
}
