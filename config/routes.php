<?php

return [
    '/' => \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeRequest::class,
    '/article' => \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article\ArticleRequest::class,
    '/search' => \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\SearchRequest::class,
    '/authentication-form' => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm\AuthenticationFormRequest::class,
    '/authentication' => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationRequest::class,
    '/logout' => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Logout\LogoutRequest::class,
    '/registration-form' => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormRequest::class,
    '/registration' => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration\RegistrationRequest::class,
    '/ping' => \Quatrevieux\Mvp\Backend\Ping\PingRequest::class,
];
