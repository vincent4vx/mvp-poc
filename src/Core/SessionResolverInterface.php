<?php

namespace Quatrevieux\Mvp\Core;

interface SessionResolverInterface
{
    public function resolve(string $token): ?object;

    public function generate(object $payload): string;

    public function destroy(string $token): void;
}
