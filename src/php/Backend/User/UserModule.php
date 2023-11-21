<?php

namespace Quatrevieux\Mvp\Backend\User;

use PDO;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationController;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm\AuthenticationFormController;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm\AuthenticationFormRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Logout\LogoutController;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Logout\LogoutRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Profile\ProfileController;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Profile\ProfileRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration\RegistrationController;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration\RegistrationRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormController;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormRequest;
use Quatrevieux\Mvp\Backend\User\Command\CreateUser;
use Quatrevieux\Mvp\Backend\User\Command\CreateUserHandler;
use Quatrevieux\Mvp\Backend\User\Command\DeleteUser;
use Quatrevieux\Mvp\Backend\User\Command\DeleteUserHandler;
use Quatrevieux\Mvp\Backend\User\Command\UpdateUser;
use Quatrevieux\Mvp\Backend\User\Command\UpdateUserHandler;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Domain\UserWriteRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserReadRepository;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserWriteRepository;
use Quatrevieux\Mvp\Core\Module\AbstractModule;
use Quatrevieux\Mvp\Core\Module\ModuleBuilder;
use Quatrevieux\Mvp\Core\Security\AuthenticationRequiredRequest;
use Quatrevieux\Mvp\Frontend\User\AuthenticationFormRenderer;
use Quatrevieux\Mvp\Frontend\User\AuthenticationRenderer;
use Quatrevieux\Mvp\Frontend\User\LogoutRenderer;
use Quatrevieux\Mvp\Frontend\User\RegistrationFormRenderer;
use Quatrevieux\Mvp\Frontend\User\RegistrationRenderer;

use function DI\create;
use function DI\get;

class UserModule extends AbstractModule
{
    protected function build(ModuleBuilder $builder): void
    {
        $builder->route('/profile', ProfileRequest::class)
            ->controller(ProfileController::class)
            ->renderer(__DIR__ . '/../../Frontend/User/Templates/profile.html.php')
            ->authenticated()
        ;

        $builder->route('/authentication', AuthenticationRequest::class)
            ->controller(AuthenticationController::class)
            ->renderer(AuthenticationRenderer::class)
            ->anonymous()
        ;

        $builder->route('/authentication-form', AuthenticationFormRequest::class)
            ->controller(AuthenticationFormController::class)
            ->renderer(AuthenticationFormRenderer::class)
            ->anonymous()
        ;

        $builder->route('/logout', LogoutRequest::class)
            ->controller(LogoutController::class)
            ->renderer(LogoutRenderer::class)
            ->authenticated()
        ;

        $builder->route('/registration', RegistrationRequest::class)
            ->controller(RegistrationController::class)
            ->renderer(RegistrationRenderer::class)
            ->anonymous()
        ;

        $builder->route('/registration-form', RegistrationFormRequest::class)
            ->controller(RegistrationFormController::class)
            ->renderer(RegistrationFormRenderer::class)
            ->anonymous()
        ;

        $builder->controllers[AuthenticationRequiredRequest::class] = AuthenticationFormController::class;

        $builder->definition(AuthenticationController::class, create()->constructor(
            get(UserReadRepositoryInterface::class),
            get('authenticated-user.pepper'),
        ));

        $builder->definition(UserWriteRepository::class, create()->constructor(get(PDO::class)));
        $builder->definition(UserReadRepository::class, create()->constructor(get(PDO::class)));

        $builder->definition(UserReadRepositoryInterface::class, get(UserReadRepository::class));
        $builder->definition(UserWriteRepositoryInterface::class, get(UserWriteRepository::class));

        $builder->handler(CreateUser::class, CreateUserHandler::class);
        $builder->handler(DeleteUser::class, DeleteUserHandler::class);
        $builder->handler(UpdateUser::class, UpdateUserHandler::class);
    }
}
