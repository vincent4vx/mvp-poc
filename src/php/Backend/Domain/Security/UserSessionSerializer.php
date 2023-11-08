<?php

namespace Quatrevieux\Mvp\Backend\Domain\Security;

use Quatrevieux\Mvp\Core\SessionSerializerInterface;

class UserSessionSerializer implements SessionSerializerInterface
{
    public function __construct(
        private readonly string $pepper,
    ) {
    }

    public function serialize(object $session): mixed
    {
        if ($session instanceof AuthenticatedUser) {
            return $session->toArray();
        }

        return [];
    }

    public function unserialize(mixed $data): object
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Invalid session data');
        }

        return AuthenticatedUser::fromArray($data, $this->pepper);
    }
}
