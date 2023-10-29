<?php

use Quatrevieux\Mvp\Backend\Blog\Domain\ArticleReadRepositoryInterface;

use Quatrevieux\Mvp\Backend\Blog\Infrastructure\PDO\ArticleSqlRepository;

use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;

use Quatrevieux\Mvp\Backend\User\Domain\UserWriteRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserRepository;

use function DI\get;

return [
    ArticleReadRepositoryInterface::class => get(ArticleSqlRepository::class),
    UserReadRepositoryInterface::class => get(UserRepository::class),
    UserWriteRepositoryInterface::class => get(UserRepository::class),
];
