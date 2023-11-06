<?php

namespace Quatrevieux\Mvp\Backend;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Backend\Error\ErrorController;
use Quatrevieux\Mvp\Core\ErroredRequest;
use Quatrevieux\Mvp\Core\Module\AbstractModule;
use Quatrevieux\Mvp\Core\Module\ModuleBuilder;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeLayoutRender;
use Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeViewContext;
use Quatrevieux\Mvp\Frontend\FrontOfficeLayoutRender;
use Quatrevieux\Mvp\Frontend\FrontOfficeViewContext;

use function DI\create;
use function DI\get;

class BaseModule extends AbstractModule
{
    protected function build(ModuleBuilder $builder): void
    {
        // @todo passer par builder
        $builder->controllers[ErroredRequest::class] = ErrorController::class;

        $builder->renderer(ErroredRequest::class, __DIR__ . '/../Frontend/Templates/error.html.php');
        $builder->renderer(BackOfficeViewContext::class, BackOfficeLayoutRender::class);
        $builder->renderer(FrontOfficeViewContext::class, FrontOfficeLayoutRender::class);

        $builder->definition(FrontOfficeLayoutRender::class, create()->constructor(
            get(Router::class),
            get(ResponseFactoryInterface::class),
            get(StreamFactoryInterface::class),
            get('assetsUrl'),
        ));
    }
}
