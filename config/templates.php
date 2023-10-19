<?php

use Quatrevieux\Mvp\Frontend\Blog\ArticleRenderer;
use Quatrevieux\Mvp\Frontend\Blog\HomeRenderer;

return [
    \Quatrevieux\Mvp\Backend\Blog\Home\HomeResponse::class => HomeRenderer::class,
    \Quatrevieux\Mvp\Backend\Blog\Article\ArticleResponse::class => ArticleRenderer::class,
    \Quatrevieux\Mvp\Backend\Blog\Search\SearchResponse::class => \Quatrevieux\Mvp\Frontend\Blog\SearchRenderer::class,
    \Quatrevieux\Mvp\Core\ViewContext::class => \Quatrevieux\Mvp\Frontend\LayoutRenderer::class,
    \Quatrevieux\Mvp\Frontend\CustomViewContext::class => \Quatrevieux\Mvp\Frontend\LayoutRenderer::class,
    \Quatrevieux\Mvp\Backend\User\AuthenticationForm\AuthenticationFormResponse::class => \Quatrevieux\Mvp\Frontend\User\AuthenticationFormRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Authentication\AuthenticationResponse::class => \Quatrevieux\Mvp\Frontend\User\AuthenticationRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Logout\LogoutResponse::class => \Quatrevieux\Mvp\Frontend\User\LogoutRenderer::class,
    \Quatrevieux\Mvp\Backend\User\RegistrationForm\RegistrationFormResponse::class => \Quatrevieux\Mvp\Frontend\User\RegistrationFormRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Registration\RegistrationResponse::class => \Quatrevieux\Mvp\Frontend\User\RegistrationRenderer::class,
    \Quatrevieux\Mvp\Backend\User\Profile\ProfileResponse::class => __DIR__ . '/../src/Frontend/User/Templates/profile.html.php',
    \Quatrevieux\Mvp\Core\ErroredRequest::class => __DIR__ . '/../src/Frontend/Templates/error.html.php',
    \Quatrevieux\Mvp\Backend\Blog\Search\AutocompleteSearchResponse::class => __DIR__ . '/../src/Frontend/Blog/Templates/search-autocomplete.html.php',
    \Quatrevieux\Mvp\Backend\Chat\Show\ShowChatResponse::class => __DIR__ . '/../src/Frontend/Chat/Templates/chat.html.php',
    \Quatrevieux\Mvp\Backend\Chat\Send\SendMessageResponse::class => \Quatrevieux\Mvp\Frontend\Chat\SendMessageRenderer::class,
    \Quatrevieux\Mvp\Backend\Chat\Event\SubscribeEventResponse::class => \Quatrevieux\Mvp\Frontend\Chat\SubscribeEventRenderer::class,
    \Quatrevieux\Mvp\Backend\Blog\Home\ArticleList::class => \Quatrevieux\Mvp\Frontend\Blog\ArticleListRenderer::class,
];
