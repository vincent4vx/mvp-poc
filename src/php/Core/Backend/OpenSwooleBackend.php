<?php

namespace Quatrevieux\Mvp\Core\Backend;

use OpenSwoole\Core\Psr\Response as PsrResponse;
use OpenSwoole\Core\Psr\ServerRequest;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Http\Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Core\Runner;
use Quatrevieux\Mvp\Core\StreamingResponseInterface;

final class OpenSwooleBackend
{
    public function __construct(
        private readonly Runner $runner,
    ) {
    }

    public function start(Server $server): void
    {
        $server->on('Request', $this->handle(...));
        $server->start();
    }

    public function handle(Request $request, Response $response): void
    {
        $psrRequest = $this->createPsrRequest($request);

        echo $psrRequest->getMethod() . ' ' . $psrRequest->getUri() . PHP_EOL;

        $appResponse = $this->runner->run($psrRequest);

        if ($appResponse instanceof StreamingResponseInterface) {
            throw new \BadMethodCallException('Streaming response is not supported by OpenSwoole backend');
        }

        PsrResponse::emit($response, $appResponse);
    }

    private function createPsrRequest(Request $request): ServerRequestInterface
    {
        return ServerRequest::from($request)
            ->withParsedBody($request->post)
        ;
    }
}
