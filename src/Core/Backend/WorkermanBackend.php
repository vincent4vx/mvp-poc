<?php

namespace Quatrevieux\Mvp\Core\Backend;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Core\Runner;
use Quatrevieux\Mvp\Core\StreamingResponseInterface;
use Workerman\Connection\ConnectionInterface;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;

use Workerman\Timer;

use Workerman\Worker;

use function array_map;
use function count;
use function function_exists;
use function opcache_get_status;

/**
 * Backend using workerman library for http server
 * The package "workerman/workerman" must be installed
 */
final class WorkermanBackend
{
    public function __construct(
        private readonly ServerRequestFactoryInterface $requestFactory,
        private readonly Runner $runner,
    ) {
    }

    public function start(Worker $worker): void
    {
        echo 'Starting server...', PHP_EOL;

        if (!self::jitIsEnabled()) {
            echo 'Warning: OPcache JIT is not enabled', PHP_EOL;
        }

        $worker->onMessage = $this->handle(...);
        $worker->name = 'Web server';

        Worker::runAll();
    }

    /**
     * Handle a single workerman request
     * This method can be used as "onMessage" callback on a workerman worker
     *
     * @param ConnectionInterface $connection
     * @param Request $request
     *
     * @return void
     *
     * @see Worker::$onMessage
     */
    public function handle(ConnectionInterface $connection, Request $request): void
    {
        $psrRequest = $this->createPsrRequest($request);
        $response = $this->runner->run($psrRequest);

        if ($response instanceof StreamingResponseInterface) {
            $this->stream($connection, $response);
        } else {
            $this->send($connection, $response);
        }
    }

    public function send(ConnectionInterface $connection, ResponseInterface $response): void
    {
        $connection->send(new Response(
            $response->getStatusCode(),

            // Workerman expects a string for Content-Type header
            array_map(fn ($headers) => (count($headers) === 1 ? $headers[0] : $headers), $response->getHeaders()),

            $response->getBody()->getContents() ?: "\n\n"
        ));
    }

    /**
     * Sending a streaming response asynchronously, using a timer
     * This is useful for long-polling or server-sent events
     *
     * @param StreamingResponseInterface $response
     */
    public function stream(ConnectionInterface $connection, StreamingResponseInterface $response): void
    {
        $psrResponse = $response->response();
        $this->send($connection, $psrResponse->withoutHeader('Content-Length'));

        $timerId = Timer::add(1, function () use ($connection, $response, &$timerId) {
            if ($connection->getStatus() !== TcpConnection::STATUS_ESTABLISHED || $response->end()) {
                Timer::del($timerId);
                return;
            }

            foreach ($response->stream() as $chunk) {
                $connection->send($chunk);
            }

            if ($response->end()) {
                Timer::del($timerId);
            }
        });
    }

    private function createPsrRequest(Request $request): ServerRequestInterface
    {
        $psrRequest = $this->requestFactory->createServerRequest($request->method(), $request->uri())
            ->withParsedBody($request->post())
            ->withQueryParams($request->get())
            ->withCookieParams($request->cookie())
        ;

        foreach ($request->header() as $name => $value) {
            $psrRequest = $psrRequest->withHeader($name, $value);
        }

        return $psrRequest;
    }

    /**
     * Check if the JIT is enabled
     *
     * @return bool true if the JIT is enabled, false otherwise
     */
    public static function jitIsEnabled(): bool
    {
        return function_exists('opcache_get_status') && !empty(opcache_get_status()['jit']['enabled']);
    }
}
