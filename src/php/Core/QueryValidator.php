<?php

namespace Quatrevieux\Mvp\Core;

class QueryValidator
{
    public function __construct(
        /**
         * @var QueryValidatorInterface[]
         */
        private readonly array $validators,
    ) {
    }

    public function validate(RoutedQuery $routedQuery): RoutedQuery
    {
        $query = $routedQuery->query;

        try {
            foreach ($this->validators as $validator) {
                $query = $validator->validate($routedQuery->request, $query) ?? $query;
            }
        } catch (\Throwable $error) {
            return new RoutedQuery(
                $routedQuery->request,
                new ErroredRequest($routedQuery->request, $routedQuery->query, $error)
            );
        }

        if ($query === $routedQuery->query) {
            return $routedQuery;
        }

        return new RoutedQuery($routedQuery->request, $query);
    }
}
