<?php

namespace Quatrevieux\Mvp\App\Search;

use Quatrevieux\Mvp\App\ArticleRepository;
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
     * @return SearchResponse
     */
    public function handle(object $request): SearchResponse
    {
        $articles = $this->repository->search($request->query, $request->tag);

        return new SearchResponse(
            count($articles),
            $articles,
            $this->repository->allTags(),
            $request->query,
            $request->tag,
        );
    }
}
