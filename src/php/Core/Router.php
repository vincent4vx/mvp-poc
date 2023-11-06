<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

use function array_filter;
use function http_build_query;
use function is_object;
use function is_string;
use function property_exists;
use function rtrim;

class Router
{
    public function __construct(
        /**
         * @var array<string, class-string>
         */
        private readonly array $paths = [],
        private readonly string $baseUrl,
    ) {
    }

    public function resolve(ServerRequestInterface $request): RoutedQuery
    {
        $basePath = parse_url($this->baseUrl, PHP_URL_PATH);
        $path = $request->getUri()->getPath();

        if (!str_starts_with($path, $basePath)) {
            throw new \InvalidArgumentException('Route not found');
        }

        $path = substr($path, strlen($basePath));
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

    public function generate(object|string $query): string
    {
        $queryClass = is_string($query) ? $query : $query::class;
        $queryParameters = is_object($query) ? array_filter((array) $query, static fn ($value) => $value !== null) : [];

        foreach ($this->paths as $path => $class) {
            if ($queryClass === $class) {
                // @todo handle /
                return $this->baseUrl . $path . ($queryParameters ? '?' . http_build_query($query) : '');
            }
        }

        throw new \InvalidArgumentException('Route not found for query ' . $queryClass);
    }
}
