<?php

use Quatrevieux\Mvp\Backend\BackOffice\Home\HomeRequest;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article\ArticleRequest;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeRequest as BlogHomeRequest;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\SearchRequest;
use Quatrevieux\Mvp\Backend\Chat\Send\SendMessageRequest;
use Quatrevieux\Mvp\Backend\Chat\Show\ShowChatRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserFormRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit\EditUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save\SaveUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm\AuthenticationFormRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Logout\LogoutRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Profile\ProfileRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration\RegistrationRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormRequest;
use Quatrevieux\Mvp\Backend\User\Domain\UserRole;

return function () {
    /**
     * @var \Quatrevieux\Mvp\Core\Security\FirewallLoader $this
     */
    return [
        BlogHomeRequest::class => $this->anonymous(),
        ArticleRequest::class => $this->anonymous(),
        SearchRequest::class => $this->anonymous(),
        AuthenticationFormRequest::class => $this->anonymous(),
        AuthenticationRequest::class => $this->anonymous(),
        RegistrationFormRequest::class => $this->anonymous(),
        RegistrationRequest::class => $this->anonymous(),
        ShowChatRequest::class => $this->anonymous(),

        SendMessageRequest::class => $this->authenticated(),
        ProfileRequest::class => $this->authenticated(),
        LogoutRequest::class => $this->authenticated(), // @todo anonymous ?

        HomeRequest::class => $this->authenticated(UserRole::ADMIN),
        ListUsersRequest::class => $this->authenticated(UserRole::ADMIN),
        CreateUserFormRequest::class => $this->authenticated(UserRole::ADMIN),
        CreateUserRequest::class => $this->authenticated(UserRole::ADMIN),
        SaveUserRequest::class => $this->authenticated(UserRole::ADMIN),
        EditUserRequest::class => $this->authenticated(UserRole::ADMIN),
    ];
};
