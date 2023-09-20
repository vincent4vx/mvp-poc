<?php

return [
    '/' => \Quatrevieux\Mvp\App\Home\HomeRequest::class,
    '/article' => \Quatrevieux\Mvp\App\Article\ArticleRequest::class,
    '/search' => \Quatrevieux\Mvp\App\Search\SearchRequest::class,
    '/authentication-form' => \Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRequest::class,
    '/authentication' => \Quatrevieux\Mvp\App\User\Authentication\AuthenticationRequest::class,
    '/logout' => \Quatrevieux\Mvp\App\User\Logout\LogoutRequest::class,
    '/registration-form' => \Quatrevieux\Mvp\App\User\RegistrationForm\RegistrationFormRequest::class,
    '/registration' => \Quatrevieux\Mvp\App\User\Registration\RegistrationRequest::class,
];