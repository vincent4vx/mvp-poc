<?php

use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;

require_once __DIR__ . '/../vendor/autoload.php';

echo 'Starting server...', PHP_EOL;

if (empty(opcache_get_status()['jit']['enabled'])) {
    echo 'Warning: OPcache JIT is not enabled', PHP_EOL;
}

$container = (new ContainerBuilder())
    ->addDefinitions(__DIR__ . '/../config/services.php')
    ->build()
;

$worker = new \Workerman\Worker('http://0.0.0.0:5000');
$worker->count = 8;

$factory = $container->get(Psr17Factory::class);
$runner = $container->get(\Quatrevieux\Mvp\Core\Runner::class);

$worker->onMessage = function (\Workerman\Connection\ConnectionInterface $connection, \Workerman\Protocols\Http\Request $request) use ($runner, $factory) {
    $psrRequest = $factory->createServerRequest($request->method(), $request->uri())
        ->withParsedBody($request->post())
        ->withQueryParams($request->get())
        ->withCookieParams($request->cookie())
    ;

    foreach ($request->header() as $name => $value) {
        $psrRequest = $psrRequest->withHeader($name, $value);
    }

    $psrResponse = $runner->run($psrRequest);

    $response = new \Workerman\Protocols\Http\Response(
        $psrResponse->getStatusCode(),
        $psrResponse->getHeaders(),
        $psrResponse->getBody()->getContents()
    );

    $connection->send($response);
};

\Workerman\Worker::runAll();

echo 'Server started on http://127.0.0.1:5000', PHP_EOL;
