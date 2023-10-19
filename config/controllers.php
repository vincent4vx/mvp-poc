<?php

return [
    \Quatrevieux\Mvp\Backend\Blog\Home\HomeRequest::class => \Quatrevieux\Mvp\Backend\Blog\Home\HomeController::class,
    \Quatrevieux\Mvp\Backend\Blog\Article\ArticleRequest::class => \Quatrevieux\Mvp\Backend\Blog\Article\ArticleController::class,
    \Quatrevieux\Mvp\Backend\Blog\Search\SearchRequest::class => \Quatrevieux\Mvp\Backend\Blog\Search\SearchController::class,
    \Quatrevieux\Mvp\Backend\User\AuthenticationForm\AuthenticationFormRequest::class => \Quatrevieux\Mvp\Backend\User\AuthenticationForm\AuthenticationFormController::class,
    \Quatrevieux\Mvp\Backend\User\Authentication\AuthenticationRequest::class => \Quatrevieux\Mvp\Backend\User\Authentication\AuthenticationController::class,
    \Quatrevieux\Mvp\Backend\User\Logout\LogoutRequest::class => \Quatrevieux\Mvp\Backend\User\Logout\LogoutController::class,
    \Quatrevieux\Mvp\Backend\User\RegistrationForm\RegistrationFormRequest::class => \Quatrevieux\Mvp\Backend\User\RegistrationForm\RegistrationFormController::class,
    \Quatrevieux\Mvp\Backend\User\Registration\RegistrationRequest::class => \Quatrevieux\Mvp\Backend\User\Registration\RegistrationController::class,
    \Quatrevieux\Mvp\Backend\Ping\PingRequest::class => \Quatrevieux\Mvp\Backend\Ping\PingController::class,
];
