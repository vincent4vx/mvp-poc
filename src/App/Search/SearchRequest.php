<?php

namespace Quatrevieux\Mvp\App\Search;

class SearchRequest
{
    public ?string $query = null;
    public ?string $tag = null;

    public static function tag(string $tag): self
    {
        $request = new self();
        $request->tag = $tag;

        return $request;
    }
}
