<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\List;

use Quatrevieux\Mvp\Backend\User\Domain\SearchUserCriteria;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

use function array_flip;
use function ceil;
use function max;

#[Handles(ListUsersRequest::class)]
class ListUsersController implements ControllerInterface
{
    public function __construct(
        private readonly UserReadRepositoryInterface $repository,
    ) {
    }

    /**
     * @param ListUsersRequest $request
     * @return ListUsersResponse
     */
    public function handle(object $request): ListUsersResponse
    {
        $criteria = new SearchUserCriteria();
        $fields = $request->fields ?: ['username', 'pseudo', 'id'];
        $request->fields = $fields;

        foreach ($fields as $field) {
            switch ($field) {
                case 'username':
                    $criteria->username = $request->search;
                    break;
                case 'pseudo':
                    $criteria->pseudo = $request->search;
                    break;
                case 'id':
                    $criteria->id = (int) $request->search;
                    break;
            }
        }

        $criteria->or = true;
        $criteria->limit = 20;
        $criteria->offset = max($request->page - 1, 0) * $criteria->limit;

        $result = $this->repository->search($criteria);

        return new ListUsersResponse(
            $request,
            max($request->page, 1),
            $result->total,
            (int) ceil($result->total / $criteria->limit),
            ...$result->users,
        );
    }
}
