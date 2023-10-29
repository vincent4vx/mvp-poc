<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

interface UserReadRepositoryInterface
{
    public function findByUsername(string $username): ?User;

    public function hasUsername(string $username): bool;

    public function findById(int $id): ?User;

    /**
     * Find all users by their ids
     * The result is an array of User indexed by their ids
     *
     * @param list<int> $ids
     *
     * @return array<int, User>
     */
    public function findAllById(array $ids): array;

    /**
     * @return User
     */
    public function search(?SearchUserCriteria $criteria = null): array;
}
