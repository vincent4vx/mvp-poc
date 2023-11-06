<?php

namespace Quatrevieux\Mvp\Backend\User;

use Quatrevieux\Mvp\Backend\BackOffice\AbstractBackOfficeModule;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserController;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserFormController;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserFormRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Delete\DeleteUserController;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Delete\DeleteUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit\EditUserController;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit\EditUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersController;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save\SaveUserController;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save\SaveUserRequest;
use Quatrevieux\Mvp\Core\Module\ModuleBuilder;
use Quatrevieux\Mvp\Frontend\BackOffice\Component\BackOfficeMenu;
use Quatrevieux\Mvp\Frontend\User\BackOffice\CreateUserFormRenderer;
use Quatrevieux\Mvp\Frontend\User\BackOffice\CreateUserRenderer;
use Quatrevieux\Mvp\Frontend\User\BackOffice\DeleteUserRenderer;
use Quatrevieux\Mvp\Frontend\User\BackOffice\EditUserRenderer;
use Quatrevieux\Mvp\Frontend\User\BackOffice\ListUsersRenderer;
use Quatrevieux\Mvp\Frontend\User\BackOffice\SaveUserRenderer;

class UserBackOfficeModule extends AbstractBackOfficeModule
{
    protected function buildBackOffice(ModuleBuilder $builder): void
    {
        $builder->prefix('/users');

        $builder->route('/', ListUsersRequest::class)
            ->controller(ListUsersController::class)
            ->renderer(ListUsersRenderer::class)
        ;

        $builder->route('/form', CreateUserFormRequest::class)
            ->controller(CreateUserFormController::class)
            ->renderer(CreateUserFormRenderer::class)
        ;

        $builder->route('/create', CreateUserRequest::class)
            ->controller(CreateUserController::class)
            ->renderer(CreateUserRenderer::class)
        ;

        $builder->route('/edit', EditUserRequest::class)
            ->controller(EditUserController::class)
            ->renderer(EditUserRenderer::class)
        ;

        $builder->route('/delete', DeleteUserRequest::class)
            ->controller(DeleteUserController::class)
            ->renderer(DeleteUserRenderer::class)
        ;

        $builder->route('/save', SaveUserRequest::class)
            ->controller(SaveUserController::class)
            ->renderer(SaveUserRenderer::class)
        ;
    }

    protected function buildBackOfficeMenu(BackOfficeMenu $menu): void
    {
        $menu->add('Users', new ListUsersRequest())
            ->with(CreateUserRequest::class)
            ->with(EditUserRequest::class)
            ->with(SaveUserRequest::class)
            ->sub('List', ListUsersRequest::class)
            ->sub('Create', CreateUserFormRequest::class)
        ;
    }
}
