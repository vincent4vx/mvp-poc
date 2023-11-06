<?php

namespace Quatrevieux\Mvp\Backend\BackOffice;

use Quatrevieux\Mvp\Backend\User\Domain\UserRole;
use Quatrevieux\Mvp\Core\Module\AbstractModule;
use Quatrevieux\Mvp\Core\Module\ModuleBuilder;
use Quatrevieux\Mvp\Frontend\BackOffice\Component\BackOfficeMenu;

use function DI\create;
use function DI\decorate;

abstract class AbstractBackOfficeModule extends AbstractModule
{
    protected final function build(ModuleBuilder $builder): void
    {
        $builder
            ->prefix('/admin')
            ->authenticatedByDefault(UserRole::ADMIN)
        ;

        $this->buildBackOffice($builder);

        $builder->definition(BackOfficeMenu::class, decorate(function (?BackOfficeMenu $menu) {
            $this->buildBackOfficeMenu($menu ?? new BackOfficeMenu());

            return $menu;
        }));
    }

    abstract protected function buildBackOffice(ModuleBuilder $builder): void;

    protected function buildBackOfficeMenu(BackOfficeMenu $menu): void
    {
        // To override
    }
}
