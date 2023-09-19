<?php

namespace Quatrevieux\Mvp\App;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\App\User\User;
use Quatrevieux\Mvp\Core\ViewContext;
use Quatrevieux\Mvp\Core\ViewContextFactoryInterface;

class CustomViewContextFactory implements ViewContextFactoryInterface
{
    public function createContext(ServerRequestInterface $request, object $query, object $response): ViewContext
    {
        $context = new CustomViewContext($request, $query, $response);

        $token = $request->getCookieParams()['token'] ?? null;

        if ($token) {
            [$payload, $signature] = explode('.', $token, 2);

            $payload = hex2bin($payload);
            $signature = hex2bin($signature);

            $expectedSignature = hash_hmac('sha256', $payload, 'secret', true);

            if (!hash_equals($expectedSignature, $signature)) {
                return $context;
            }

            $jsonPayload = json_decode($payload, true);
            $context->user = new User(
                $jsonPayload['id'],
                $jsonPayload['username'],
                $jsonPayload['password'],
                $jsonPayload['pseudo'],
            );
        }

        return $context;
    }
}
