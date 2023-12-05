<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Search;

use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\ArticleList;
use Quatrevieux\Mvp\Backend\Blog\Domain\ArticleReadRepositoryInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(SearchRequest::class)]
class SearchController implements ControllerInterface
{
    public function __construct(
        private readonly ArticleReadRepositoryInterface $repository,
    ) {
    }

    /**
     * @param SearchRequest $request
     * @return SearchResponse|AutocompleteSearchResponse
     */
    public function handle(object $request): SearchResponse|AutocompleteSearchResponse
    {
        $articles = $request->empty() ? [] : $this->repository->search($request->query, $request->tag);

        if ($request->autocomplete) {
            return new AutocompleteSearchResponse(ArticleList::fromArticles(...$articles));
        }

        return new SearchResponse(
            count($articles),
            ArticleList::fromArticles(...$articles),
            $this->repository->allTags(),
            $request->query,
            $request->tag,
        );
    }
}
