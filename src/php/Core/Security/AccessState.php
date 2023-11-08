<?php

namespace Quatrevieux\Mvp\Core\Security;

enum AccessState
{
    case Authorized;
    case AuthenticationRequired;
    case NotEnoughPermissions;
    // @todo need upgrade state ?
}
