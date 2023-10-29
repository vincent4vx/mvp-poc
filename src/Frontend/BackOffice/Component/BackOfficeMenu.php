<?php

namespace Quatrevieux\Mvp\Frontend\BackOffice\Component;

use ArrayIterator;
use IteratorAggregate;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserFormRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit\EditUserRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\List\ListUsersRequest;
use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save\SaveUserRequest;
use Traversable;

/**
 * @implements IteratorAggregate<BackOfficeMenuItem>
 */
class BackOfficeMenu implements IteratorAggregate
{
    /**
     * @var list<BackOfficeMenuItem>
     */
    private array $items = [];

    public function __construct()
    {
        // @todo make this configurable
        $this->add('Users', new ListUsersRequest())
            ->with(CreateUserRequest::class)
            ->with(EditUserRequest::class)
            ->with(SaveUserRequest::class)
            ->sub('List', ListUsersRequest::class)
            ->sub('Create', CreateUserFormRequest::class)
        ;
    }

    public function add(string $label, object $request): BackOfficeMenuItem
    {
        return $this->items[] = new BackOfficeMenuItem($label, $request);
    }

    public function active(object $request): ?BackOfficeMenuItem
    {
        foreach ($this->items as $item) {
            if ($item->active($request)) {
                return $item;
            }
        }

        return null;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
