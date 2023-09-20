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

    public function validate(RoutedQuery $routedQuery): void
    {
        foreach ($this->validators as $validator) {
            $validator->validate($routedQuery->request, $routedQuery->query);
        }
    }
}
