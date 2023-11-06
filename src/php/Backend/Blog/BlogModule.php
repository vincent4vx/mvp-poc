<?php

namespace Quatrevieux\Mvp\Backend\Blog;

use Michelf\Markdown;
use Michelf\MarkdownInterface;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article\ArticleController;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article\ArticleRequest;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\ArticleList;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeController;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeRequest;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\AutocompleteSearchResponse;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\SearchController;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\SearchRequest;
use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search\SearchResponse;
use Quatrevieux\Mvp\Backend\Blog\Domain\ArticleReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\Blog\Infrastructure\PDO\ArticleSqlRepository;
use Quatrevieux\Mvp\Core\Module\AbstractModule;
use Quatrevieux\Mvp\Core\Module\ModuleBuilder;
use Quatrevieux\Mvp\Core\Security\AnonymousAccess;
use Quatrevieux\Mvp\Frontend\Blog\ArticleListRenderer;
use Quatrevieux\Mvp\Frontend\Blog\ArticleRenderer;
use Quatrevieux\Mvp\Frontend\Blog\HomeRenderer;
use Quatrevieux\Mvp\Frontend\Blog\SearchRenderer;

use function DI\autowire;
use function DI\create;
use function DI\get;

class BlogModule extends AbstractModule
{
    protected function build(ModuleBuilder $builder): void
    {
        $builder->anonymousByDefault();

        $builder->route('/', HomeRequest::class)
            ->controller(HomeController::class)
            ->renderer(HomeRenderer::class)
        ;

        $builder->route('/article', ArticleRequest::class)
            ->controller(ArticleController::class)
            ->renderer(ArticleRenderer::class)
        ;

        $builder->route('/search', SearchRequest::class)
            ->controller(SearchController::class)
            ->renderer(SearchRenderer::class, SearchResponse::class)
            ->renderer(__DIR__ . '/../../Frontend/Blog/Templates/search-autocomplete.html.php', AutocompleteSearchResponse::class)
        ;

        $builder->renderer(ArticleList::class, ArticleListRenderer::class);

        $builder->definition(MarkdownInterface::class, create(Markdown::class));
        $builder->definition(ArticleSqlRepository::class, autowire());
        $builder->definition(ArticleReadRepositoryInterface::class, get(ArticleSqlRepository::class));
    }
}
