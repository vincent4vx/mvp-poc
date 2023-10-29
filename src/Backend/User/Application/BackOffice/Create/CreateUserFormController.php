<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create;

use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(CreateUserFormRequest::class)]
class CreateUserFormController implements ControllerInterface
{
    /**
     * @param CreateUserFormRequest $request
     * @return CreateUserFormResponse
     */
    public function handle(object $request): object
    {
        return new CreateUserFormResponse();
    }
}
