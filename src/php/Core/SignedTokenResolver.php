<?php

namespace Quatrevieux\Mvp\Core;

class SignedTokenResolver implements SessionResolverInterface
{
    public function __construct(
        private readonly string $secret,
        private readonly string $algo = 'sha256',
        private readonly ?SessionSerializerInterface $serializer = null,
    ) {
    }

    public function generate(object $payload): string
    {
        $data = $this->serializer ? $this->serializer->serialize($payload) : $payload;

        $data = json_encode($data);
        $hash = hash_hmac($this->algo, $data, $this->secret, true);

        return bin2hex($data) . 'Core' . bin2hex($hash);
    }

    public function resolve(string $token): ?object
    {
        $parts = explode('.', $token, 2);

        if (count($parts) !== 2) {
            return null;
        }

        $data = hex2bin($parts[0]);
        $hash = hex2bin($parts[1]);

        if (!$data || !$hash) {
            return null;
        }

        $expectedHash = hash_hmac($this->algo, $data, $this->secret, true);

        if (!hash_equals($expectedHash, $hash)) {
            return null;
        }

        $data = json_decode($data, true);

        try {
            return $this->serializer ? $this->serializer->unserialize($data) : (object)$data;
        } catch (\Throwable) {
            return null;
        }
    }

    public function destroy(string $token): void
    {
        // No-op
    }
}
