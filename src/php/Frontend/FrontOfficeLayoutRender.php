<?php

namespace Quatrevieux\Mvp\Frontend;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Core\Router;

class FrontOfficeLayoutRender extends LayoutRenderer
{
    public function __construct(Router $router, ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory, string $assetsUrl)
    {
        parent::__construct($router, $responseFactory, $streamFactory, $assetsUrl, __DIR__ . '/Templates/layout.html.php');
    }
}
