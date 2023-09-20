<?php

namespace Quatrevieux\Mvp\App\User;

use Quatrevieux\Mvp\Core\SessionSerializerInterface;

class UserSessionSerializer implements SessionSerializerInterface
{
    public function serialize(object $session): mixed
    {
        // @todo filter password
        return (array) $session;
    }

    public function unserialize(mixed $data): object
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Invalid session data');
        }

        return new User(
            id: $data['id'],
            username: $data['username'],
            password: $data['password'],
            pseudo: $data['pseudo'],
        );
    }
}
