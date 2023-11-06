<?php

namespace Quatrevieux\Mvp\Backend\BackOffice;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Backend\BackOffice\Home\HomeController;
use Quatrevieux\Mvp\Backend\BackOffice\Home\HomeRequest;
use Quatrevieux\Mvp\Core\Module\ModuleBuilder;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\Security\Firewall;
use Quatrevieux\Mvp\Core\View\RendererFactoryInterface;
use Quatrevieux\Mvp\Core\View\RendererInterface;
use Quatrevieux\Mvp\Core\View\ViewContextFactoryInterface;
use Quatrevieux\Mvp\Frontend\ApplicationRenderer;
use Quatrevieux\Mvp\Frontend\ApplicationViewContextFactory;
use Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeLayoutRender;
use Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeViewContext;
use Quatrevieux\Mvp\Frontend\BackOffice\Component\BackOfficeMenu;
use Quatrevieux\Mvp\Frontend\BackOffice\HomeRenderer;

use function DI\create;
use function DI\get;
use function is_subclass_of;

class BackOfficeModule extends AbstractBackOfficeModule
{
    protected function buildBackOffice(ModuleBuilder $builder): void
    {
        $builder->route('/', HomeRequest::class)
            ->controller(HomeController::class)
            ->renderer(HomeRenderer::class)
        ;

        $builder->renderer(BackOfficeViewContext::class, BackOfficeLayoutRender::class);

        $builder->definition(BackOfficeLayoutRender::class, create()->constructor(
            get(Router::class),
            get(ResponseFactoryInterface::class),
            get(StreamFactoryInterface::class),
            get('assetsUrl'),
        ));

        $builder->definition(RendererFactoryInterface::class, function (ContainerInterface $container) {
            return new class ($container) implements RendererFactoryInterface {
                public function __construct(
                    private readonly ContainerInterface $container,
                ) {
                }

                public function forTemplate(string $template): RendererInterface
                {
                    if (is_subclass_of($template, RendererInterface::class)) {
                        return $this->container->get($template);
                    }

                    return new ApplicationRenderer(
                        $this->container->get(Firewall::class),
                        $this->container->get(Router::class),
                        $template,
                    );
                }
            };
        });

        $builder->definition(ViewContextFactoryInterface::class, get(ApplicationViewContextFactory::class));
        $builder->definition(BackOfficeMenu::class, create());
    }
}
