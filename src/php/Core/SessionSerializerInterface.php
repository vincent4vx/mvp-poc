<?php

namespace Quatrevieux\Mvp\Core;

interface SessionSerializerInterface
{
    public function serialize(object $session): mixed;
    public function unserialize(mixed $data): object;
}
