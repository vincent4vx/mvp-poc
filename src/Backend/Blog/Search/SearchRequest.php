<?php

namespace Quatrevieux\Mvp\Backend\Blog\Search;

use Quatrevieux\Mvp\Core\Route;

#[Route('/search')]
class SearchRequest
{
    public ?string $query = null;
    public ?string $tag = null;
    public bool $autocomplete = false;

    public function empty(): bool
    {
        return !$this->query && !$this->tag;
    }

    public static function tag(string $tag): self
    {
        $request = new self();
        $request->tag = $tag;

        return $request;
    }

    public static function autocomplete(): self
    {
        $request = new self();
        $request->autocomplete = true;

        return $request;
    }
}
