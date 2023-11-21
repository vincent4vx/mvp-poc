<?php

namespace Quatrevieux\Mvp\Core;

interface QueryDecoratorInterface
{
    public function previousQuery(): ?object;
}
