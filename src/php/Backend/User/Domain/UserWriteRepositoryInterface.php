<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

interface UserWriteRepositoryInterface
{
    public function create(UserCreation $user): User;

    public function update(User $user): bool;

    public function delete(User $user): bool;
}
