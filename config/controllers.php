<?php

return [
    \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeRequest::class => \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeController::class,
    \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article\ArticleRequest::class => \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article\ArticleController::class,
    \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\SearchRequest::class => \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\SearchController::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm\AuthenticationFormRequest::class => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm\AuthenticationFormController::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationRequest::class => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationController::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Logout\LogoutRequest::class => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Logout\LogoutController::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormRequest::class => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormController::class,
    \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration\RegistrationRequest::class => \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration\RegistrationController::class,
    \Quatrevieux\Mvp\Backend\Ping\PingRequest::class => \Quatrevieux\Mvp\Backend\Ping\PingController::class,
];
