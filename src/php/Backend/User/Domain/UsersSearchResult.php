<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

use Exception;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, User>
 */
final class UsersSearchResult implements IteratorAggregate
{
    /**
     * @var User[]
     */
    public readonly array $users;

    public function __construct(
        public readonly int $total,
        public readonly int $offset,
        public readonly int $limit,
        User ...$users,
    ) {
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        yield from $this->users;
    }
}
