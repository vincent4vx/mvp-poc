<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

class ViewContext
{
    public ?string $title = null;
    public string $content;
    public array $components = [];

    public function __construct(
        public readonly ServerRequestInterface $request,
        public readonly object $query,
        public readonly object $response,
    ) {
    }

    public function export(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}
