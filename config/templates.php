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
    \Quatrevieux\Mvp\App\MenuBar::class => \Quatrevieux\Mvp\App\MenuBarRenderer::class,
];
