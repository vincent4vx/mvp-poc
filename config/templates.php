<?php

use Quatrevieux\Mvp\Frontend\Blog\ArticleRenderer;
use Quatrevieux\Mvp\Frontend\Blog\HomeRenderer;

return [
    \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeResponse::class => HomeRenderer::class,
    \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article\ArticleResponse::class => ArticleRenderer::class,
    \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\SearchResponse::class => \Quatrevieux\Mvp\Frontend\Blog\SearchRenderer::class,
    \Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeViewContext::class => \Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeLayoutRender::class,
    \Quatrevieux\Mvp\Frontend\FrontOfficeViewContext::class => \Quatrevieux\Mvp\Frontend\FrontOfficeLayoutRender::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm\AuthenticationFormResponse::class => \Quatrevieux\Mvp\Frontend\User\AuthenticationFormRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationResponse::class => \Quatrevieux\Mvp\Frontend\User\AuthenticationRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Logout\LogoutResponse::class => \Quatrevieux\Mvp\Frontend\User\LogoutRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormResponse::class => \Quatrevieux\Mvp\Frontend\User\RegistrationFormRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration\RegistrationResponse::class => \Quatrevieux\Mvp\Frontend\User\RegistrationRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Profile\ProfileResponse::class => __DIR__ . '/../src/Frontend/User/Templates/profile.html.php',
    \Quatrevieux\Mvp\Core\ErroredRequest::class => __DIR__ . '/../src/Frontend/Templates/error.html.php',
    \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\AutocompleteSearchResponse::class => __DIR__ . '/../src/Frontend/Blog/Templates/search-autocomplete.html.php',
    \Quatrevieux\Mvp\Backend\Chat\Show\ShowChatResponse::class => __DIR__ . '/../src/Frontend/Chat/Templates/chat.html.php',
    \Quatrevieux\Mvp\Backend\Chat\Send\SendMessageResponse::class => \Quatrevieux\Mvp\Frontend\Chat\SendMessageRenderer::class,
    \Quatrevieux\Mvp\Backend\Chat\Event\SubscribeEventResponse::class => \Quatrevieux\Mvp\Frontend\Chat\SubscribeEventRenderer::class,
    \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\ArticleList::class => \Quatrevieux\Mvp\Frontend\Blog\ArticleListRenderer::class,
    \Quatrevieux\Mvp\Backend\BackOffice\Home\HomeResponse::class => \Quatrevieux\Mvp\Frontend\BackOffice\HomeRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersResponse::class => \Quatrevieux\Mvp\Frontend\User\BackOffice\ListUsersRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserFormResponse::class => \Quatrevieux\Mvp\Frontend\User\BackOffice\CreateUserFormRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserResponse::class => \Quatrevieux\Mvp\Frontend\User\BackOffice\CreateUserRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit\EditUserResponse::class => \Quatrevieux\Mvp\Frontend\User\BackOffice\EditUserRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save\SaveUserResponse::class => \Quatrevieux\Mvp\Frontend\User\BackOffice\SaveUserRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Application\BackOffice\Delete\DeleteUserResponse::class => \Quatrevieux\Mvp\Frontend\User\BackOffice\DeleteUserRenderer::class,
];
