<?php

use Quatrevieux\Mvp\App\Article\ArticleRenderer;
use Quatrevieux\Mvp\App\Home\HomeRenderer;

return [
    \Quatrevieux\Mvp\App\Home\HomeResponse::class => HomeRenderer::class,
    \Quatrevieux\Mvp\App\Article\ArticleResponse::class => ArticleRenderer::class,
    \Quatrevieux\Mvp\App\Search\SearchResponse::class => \Quatrevieux\Mvp\App\Search\SearchRenderer::class,
    \Quatrevieux\Mvp\Core\ViewContext::class => \Quatrevieux\Mvp\App\LayoutRenderer::class,
    \Quatrevieux\Mvp\App\CustomViewContext::class => \Quatrevieux\Mvp\App\LayoutRenderer::class,
    \Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormResponse::class => \Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRenderer::class,
    \Quatrevieux\Mvp\App\User\Authentication\AuthenticationResponse::class => \Quatrevieux\Mvp\App\User\Authentication\AuthenticationRenderer::class,
    \Quatrevieux\Mvp\App\User\Logout\LogoutResponse::class => \Quatrevieux\Mvp\App\User\Logout\LogoutRenderer::class,
    \Quatrevieux\Mvp\App\User\RegistrationForm\RegistrationFormResponse::class => \Quatrevieux\Mvp\App\User\RegistrationForm\RegistrationFormRenderer::class,
    \Quatrevieux\Mvp\App\User\Registration\RegistrationResponse::class => \Quatrevieux\Mvp\App\User\Registration\RegistrationRenderer::class,
    \Quatrevieux\Mvp\App\User\Profile\ProfileResponse::class => __DIR__ . '/../template/profile.html.php',
    \Quatrevieux\Mvp\Core\ErroredRequest::class => __DIR__ . '/../template/error.html.php',
    \Quatrevieux\Mvp\App\Search\AutocompleteSearchResponse::class => __DIR__ . '/../template/search-autocomplete.html.php',
    \Quatrevieux\Mvp\App\Chat\Show\ShowChatResponse::class => __DIR__ . '/../template/chat.html.php',
    \Quatrevieux\Mvp\App\Chat\Send\SendMessageResponse::class => \Quatrevieux\Mvp\App\Chat\Send\SendMessageRenderer::class,
    \Quatrevieux\Mvp\App\Chat\Event\SubscribeEventResponse::class => \Quatrevieux\Mvp\App\Chat\Event\SubscribeEventRenderer::class,
];
