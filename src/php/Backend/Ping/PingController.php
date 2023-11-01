<?php

namespace Quatrevieux\Mvp\Backend\Ping;

use Nyholm\Psr7\Response;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(PingRequest::class)]
class PingController implements ControllerInterface
{
    /**
     * @param PingRequest $request
     * @return object
     */
    public function handle(object $request): object
    {
        return new Response(200, [], $request->message ?? 'pong');
    }
}
