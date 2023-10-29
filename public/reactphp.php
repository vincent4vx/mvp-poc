<?php

use DI\ContainerBuilder;
use Quatrevieux\Mvp\Core\Dispatcher;
use Quatrevieux\Mvp\Core\QueryValidator;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\View;

require_once __DIR__ . '/../vendor/autoload.php';

echo 'Starting server...', PHP_EOL;

if (empty(opcache_get_status()['jit']['enabled'])) {
    echo 'Warning: OPcache JIT is not enabled', PHP_EOL;
}

$container = (new ContainerBuilder())
    ->addDefinitions(
        __DIR__ . '/../config/services.php',
        __DIR__ . '/../config/adapters.php',
    )
    ->build()
;

$http = new React\Http\HttpServer(function (Psr\Http\Message\ServerRequestInterface $request) use ($container) {
    $action = $container->get(Router::class)->resolve($request);

// @todo handle errors
    $container->get(QueryValidator::class)->validate($action);

    $result = $container->get(Dispatcher::class)->dispatch($action);

    return $container->get(View::class)->response($result);
    //return new \React\Promise\Promise(function ($resolve) use ($result, $container) {
    //    $resolve($container->get(View::class)->response($result));
    //});
});

$socket = new React\Socket\SocketServer('127.0.0.1:5000');
$http->listen($socket);

echo 'Server started on http://127.0.0.1:5000', PHP_EOL;
