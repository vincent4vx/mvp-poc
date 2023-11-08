<?php

namespace Quatrevieux\Mvp\Backend\BackOffice;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Backend\BackOffice\Home\HomeController;
use Quatrevieux\Mvp\Backend\BackOffice\Home\HomeRequest;
use Quatrevieux\Mvp\Backend\BackOffice\Security\AdminAccessValidator;
use Quatrevieux\Mvp\Backend\BackOffice\Security\UpgradeSessionController;
use Quatrevieux\Mvp\Backend\BackOffice\Security\UpgradeSessionRequest;
use Quatrevieux\Mvp\Backend\BackOffice\Security\UpgradeSessionResponse;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Core\Module\ModuleBuilder;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\Security\Firewall;
use Quatrevieux\Mvp\Core\SessionHandler;
use Quatrevieux\Mvp\Core\View\RendererFactoryInterface;
use Quatrevieux\Mvp\Core\View\RendererInterface;
use Quatrevieux\Mvp\Core\View\ViewContextFactoryInterface;
use Quatrevieux\Mvp\Frontend\ApplicationRenderer;
use Quatrevieux\Mvp\Frontend\ApplicationViewContextFactory;
use Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeLayoutRender;
use Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeViewContext;
use Quatrevieux\Mvp\Frontend\BackOffice\Component\BackOfficeMenu;
use Quatrevieux\Mvp\Frontend\BackOffice\HomeRenderer;

use Quatrevieux\Mvp\Frontend\BackOffice\UpgradeSessionRenderer;

use function DI\create;
use function DI\get;
use function DI\value;
use function is_subclass_of;

class BackOfficeModule extends AbstractBackOfficeModule
{
    public const ADMIN_ACCESS_QUERIES_KEY = 'admin-access-queries';

    protected function buildBackOffice(ModuleBuilder $builder): void
    {
        $builder->route('/', HomeRequest::class)
            ->controller(HomeController::class)
            ->renderer(HomeRenderer::class)
        ;

        $builder->route('/access', UpgradeSessionRequest::class)
            ->controller(UpgradeSessionController::class)
        ;

        $builder->renderer(BackOfficeViewContext::class, BackOfficeLayoutRender::class);
        $builder->renderer(UpgradeSessionResponse::class, UpgradeSessionRenderer::class);

        $builder->definition(BackOfficeLayoutRender::class, create()->constructor(
            get(Router::class),
            get(ResponseFactoryInterface::class),
            get(StreamFactoryInterface::class),
            get('assetsUrl'),
        ));

        $builder->definition(UpgradeSessionController::class, create()->constructor(
            get(UserReadRepositoryInterface::class),
            get(Router::class),
            get('authenticated-user.pepper'),
        ));

        $builder->definition(AdminAccessValidator::class, create()->constructor(
            get(SessionHandler::class),
            get(self::ADMIN_ACCESS_QUERIES_KEY),
        ));

        $builder->definition(self::ADMIN_ACCESS_QUERIES_KEY, value([]));

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
