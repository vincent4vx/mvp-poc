<?php

namespace Quatrevieux\Mvp\Core;

interface SessionBearerInterface
{
    // @todo Session class
    public function setSession(object $session): void;
    public function session(): ?object;
}
