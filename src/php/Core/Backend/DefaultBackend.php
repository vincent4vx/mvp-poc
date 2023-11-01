<?php

namespace Quatrevieux\Mvp\Core\Backend;

use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Core\Runner;
use Quatrevieux\Mvp\Core\StreamingResponseInterface;

use function connection_aborted;
use function flush;
use function header;
use function ob_end_flush;
use function ob_get_level;
use function sprintf;
use function usleep;

/**
 * Backend for httpd servers like Apache or Nginx
 * This backend will use PHP globals and headers/echo functions, so it can only be used once per request
 */
final class DefaultBackend
{
    public function __construct(
        private readonly ServerRequestCreator $requestCreator,
        private readonly Runner $runner,
    ) {
    }

    /**
     * Run the HTTP request and send the response to the client
     * If no request is provided, the request will be created from the global variables
     *
     * Note: This method will send headers and body to the client, so it can only be called once.
     *
     * @param RequestInterface|null $request
     * @return void
     */
    public function run(?RequestInterface $request = null): void
    {
        $request ??= $this->requestCreator->fromGlobals();
        $response = $this->runner->run($request);

        if ($response instanceof StreamingResponseInterface) {
            $this->stream($response);
        } else {
            $this->send($response);
        }
    }

    /**
     * Send the response to the client
     *
     * Note: This method will send headers and body to the client, so it can only be called once.
     *
     * @param ResponseInterface $response
     * @return void
     */
    public function send(ResponseInterface $response): void
    {
        $statusLine = sprintf(
            'HTTP/%s %s %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase(),
        );

        header($statusLine);

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header("$name: $value", false);
            }
        }

        $body = $response->getBody();

        echo $body;
    }

    /**
     * Sending a streaming response to the client
     * This is useful for long-polling or server-sent events
     *
     * @param StreamingResponseInterface $response
     * @return never This method will exit the script once the response is ended
     */
    public function stream(StreamingResponseInterface $response): never
    {
        $psrResponse = $response->response();
        $this->send($psrResponse->withoutHeader('Content-Length'));

        while (!$response->end()) {
            foreach ($response->stream() as $content) {
                echo $content;

                if (ob_get_level() > 0) {
                    ob_end_flush();
                }

                flush();
            }

            if (connection_aborted()) {
                $response->close();
                break;
            }

            usleep(1000);
        }

        exit;
    }
}
