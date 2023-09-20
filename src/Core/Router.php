<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

use function http_build_query;
use function property_exists;
use function rtrim;

class Router
{
    public function __construct(
        /**
         * @var array<string, class-string>
         */
        private readonly array $paths = [],
    ) {
    }

    public function resolve(ServerRequestInterface $request): RoutedQuery
    {
        $path = $request->getUri()->getPath();
        $path = rtrim($path, '/') ?: '/';

        if (!isset($this->paths[$path])) {
            throw new \InvalidArgumentException('Route not found');
        }

        $query = new $this->paths[$path]();

        foreach ($request->getQueryParams() as $key => $value) {
            if (property_exists($query, $key)) {
                $query->{$key} = $value;
            }
        }

        foreach ((array) $request->getParsedBody() as $key => $value) {
            if (property_exists($query, $key)) {
                $query->{$key} = $value;
            }
        }

        return new RoutedQuery($request, $query);
    }

    public function generate(object $query): string
    {
        foreach ($this->paths as $path => $class) {
            if ($query instanceof $class) {
                $queryString = (array) $query;

                return $path . ($queryString ? '?' . http_build_query($queryString) : '');
            }
        }

        throw new \InvalidArgumentException('Route not found');
    }
}
