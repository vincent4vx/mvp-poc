<?php

namespace Quatrevieux\Mvp\Backend\BackOffice\Security;

use Quatrevieux\Mvp\Backend\BackOffice\BackOfficeRequest;
use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;

class UpgradeSessionRequest extends BackOfficeRequest
{
    public object|string|null $target = null;
    public ?string $password = null;

    public static function create(object $target, AuthenticatedUser $currentSession): self
    {
        $request = new self();

        $request->target = $target;
        $request->setSession($currentSession);

        return $request;
    }
}
