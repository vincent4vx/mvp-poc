<?php

namespace Quatrevieux\Mvp\Backend\Blog\Search;

use Quatrevieux\Mvp\Backend\Blog\ArticleRepository;
use Quatrevieux\Mvp\Backend\Blog\Home\ArticleList;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(SearchRequest::class)]
class SearchController implements ControllerInterface
{
    public function __construct(
        private readonly ArticleRepository $repository,
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
            return new AutocompleteSearchResponse($articles);
        }

        return new SearchResponse(
            count($articles),
            new ArticleList($articles),
            $this->repository->allTags(),
            $request->query,
            $request->tag,
        );
    }
}
