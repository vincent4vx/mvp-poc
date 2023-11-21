<?php

namespace Quatrevieux\Mvp\Backend\BackOffice\Security;

use Quatrevieux\Mvp\Backend\BackOffice\BackOfficeRequest;
use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;
use Quatrevieux\Mvp\Core\QueryDecoratorInterface;

use function is_object;

class UpgradeSessionRequest extends BackOfficeRequest implements QueryDecoratorInterface
{
    public object|string|null $target = null;
    public ?string $password = null;

    public function previousQuery(): ?object
    {
        if (is_object($this->target)) {
            return $this->target;
        }

        return null;
    }

    public static function create(object $target, AuthenticatedUser $currentSession): self
    {
        $request = new self();

        $request->target = $target;
        $request->setSession($currentSession);

        return $request;
    }
}
