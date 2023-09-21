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
        try {
            foreach ($this->validators as $validator) {
                $validator->validate($routedQuery->request, $routedQuery->query);
            }
        } catch (\Throwable $error) {
            return new RoutedQuery(
                $routedQuery->request,
                new ErroredRequest($routedQuery->request, $routedQuery->query, $error)
            );
        }

        return $routedQuery;
    }
}
