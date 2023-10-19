<?php

namespace Quatrevieux\Mvp\Backend\User;

use Quatrevieux\Mvp\Core\SessionSerializerInterface;

class UserSessionSerializer implements SessionSerializerInterface
{
    public function serialize(object $session): mixed
    {
        return $session->toArray();
    }

    public function unserialize(mixed $data): object
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Invalid session data');
        }

        return AuthenticatedUser::fromArray($data);
    }
}
