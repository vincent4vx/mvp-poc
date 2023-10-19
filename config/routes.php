<?php

return [
    '/' => \Quatrevieux\Mvp\Backend\Blog\Home\HomeRequest::class,
    '/article' => \Quatrevieux\Mvp\Backend\Blog\Article\ArticleRequest::class,
    '/search' => \Quatrevieux\Mvp\Backend\Blog\Search\SearchRequest::class,
    '/authentication-form' => \Quatrevieux\Mvp\Backend\User\AuthenticationForm\AuthenticationFormRequest::class,
    '/authentication' => \Quatrevieux\Mvp\Backend\User\Authentication\AuthenticationRequest::class,
    '/logout' => \Quatrevieux\Mvp\Backend\User\Logout\LogoutRequest::class,
    '/registration-form' => \Quatrevieux\Mvp\Backend\User\RegistrationForm\RegistrationFormRequest::class,
    '/registration' => \Quatrevieux\Mvp\Backend\User\Registration\RegistrationRequest::class,
    '/ping' => \Quatrevieux\Mvp\Backend\Ping\PingRequest::class,
];
