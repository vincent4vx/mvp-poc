<?php

use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Quatrevieux\Mvp\Core\Dispatcher;
use Quatrevieux\Mvp\Core\QueryValidator;
use Quatrevieux\Mvp\Core\View;
use Quatrevieux\Mvp\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$container = (new ContainerBuilder())
    ->addDefinitions(__DIR__ . '/../config/services.php')
    ->build()
;

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $container->get(Psr17Factory::class),
    $container->get(Psr17Factory::class),
    $container->get(Psr17Factory::class),
    $container->get(Psr17Factory::class)
);

$request = $creator->fromGlobals();

$action = $container->get(Router::class)->resolve($request);

// @todo handle errors
$container->get(QueryValidator::class)->validate($action);

$result = $container->get(Dispatcher::class)->dispatch($action);

$response = $container->get(View::class)->response($result);

// Step 1: Send the "status line".
$statusLine = sprintf('HTTP/%s %s %s'
    , $response->getProtocolVersion()
    , $response->getStatusCode()
    , $response->getReasonPhrase()
);
header($statusLine, TRUE); /* The header replaces a previous similar header. */

// Step 2: Send the response headers from the headers list.
foreach ($response->getHeaders() as $name => $values) {
    $responseHeader = sprintf('%s: %s'
        , $name
        , $response->getHeaderLine($name)
    );
    header($responseHeader, FALSE); /* The header doesn't replace a previous similar header. */
}

$body = $response->getBody();
header(sprintf('Content-Length: %d', $body->getSize()));
header('Connection: close');

// Step 3: Output the message body.
echo $body;
