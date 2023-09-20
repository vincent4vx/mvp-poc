<?php

return [
    \Quatrevieux\Mvp\App\Home\HomeRequest::class => \Quatrevieux\Mvp\App\Home\HomeController::class,
    \Quatrevieux\Mvp\App\Article\ArticleRequest::class => \Quatrevieux\Mvp\App\Article\ArticleController::class,
    \Quatrevieux\Mvp\App\Search\SearchRequest::class => \Quatrevieux\Mvp\App\Search\SearchController::class,
    \Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRequest::class => \Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormController::class,
    \Quatrevieux\Mvp\App\User\Authentication\AuthenticationRequest::class => \Quatrevieux\Mvp\App\User\Authentication\AuthenticationController::class,
    \Quatrevieux\Mvp\App\User\Logout\LogoutRequest::class => \Quatrevieux\Mvp\App\User\Logout\LogoutController::class,
    \Quatrevieux\Mvp\App\User\RegistrationForm\RegistrationFormRequest::class => \Quatrevieux\Mvp\App\User\RegistrationForm\RegistrationFormController::class,
    \Quatrevieux\Mvp\App\User\Registration\RegistrationRequest::class => \Quatrevieux\Mvp\App\User\Registration\RegistrationController::class,
];
