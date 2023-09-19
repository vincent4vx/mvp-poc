<?php

use DI\ContainerBuilder;
use Quatrevieux\Mvp\Core\Dispatcher;
use Quatrevieux\Mvp\Core\View;
use Quatrevieux\Mvp\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$container = (new ContainerBuilder())
    ->addDefinitions(__DIR__ . '/../config/services.php')
    ->build()
;

$http = new React\Http\HttpServer(function (Psr\Http\Message\ServerRequestInterface $request) use ($container) {
    $action = $container->get(Router::class)->resolve($request);
    $result = $container->get(Dispatcher::class)->dispatch($action);

    return $container->get(View::class)->response($result);
});

$socket = new React\Socket\SocketServer('127.0.0.1:5000');
$http->listen($socket);
