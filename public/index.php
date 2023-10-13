<?php

use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Quatrevieux\Mvp\Core\Dispatcher;
use Quatrevieux\Mvp\Core\QueryValidator;
use Quatrevieux\Mvp\Core\View;
use Quatrevieux\Mvp\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';

//sleep(1);
//usleep(500000);

$container = (new ContainerBuilder())
    ->addDefinitions(__DIR__ . '/../config/services.php')
    ->build()
;


$factory = $container->get(Psr17Factory::class);
$runner = $container->get(\Quatrevieux\Mvp\Core\Runner::class);

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $factory,
    $factory,
    $factory,
    $factory
);

$request = $creator->fromGlobals();
$response = $runner->run($request);

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
