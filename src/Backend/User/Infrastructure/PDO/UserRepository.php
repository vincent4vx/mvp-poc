<?php

namespace Quatrevieux\Mvp\Backend\User\Infrastructure\PDO;

use PDO;
use Quatrevieux\Mvp\Backend\User\Domain\SearchUserCriteria;
use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Domain\UserCreation;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Domain\UserWriteRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;

use function array_column;
use function count;
use function implode;
use function str_repeat;

class UserRepository implements UserReadRepositoryInterface, UserWriteRepositoryInterface
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    public function findByUsername(string $username): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE username = :username');
        $stmt->bindValue('username', $username);
        $stmt->execute(['username' => $username]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return $this->instantiate($row);
    }

    public function hasUsername(string $username): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM user WHERE username = :username');
        $stmt->bindValue('username', $username);
        $stmt->execute(['username' => $username]);

        return $stmt->fetchColumn() > 0;
    }

    public function create(UserCreation $user): User
    {
        // @todo use dedicated class for this
        $stmt = $this->pdo->prepare('INSERT INTO user (username, password, pseudo) VALUES (:username, :password, :pseudo)');

        $stmt->bindValue('username', $user->username->value);
        $stmt->bindValue('password', $user->password->value);
        $stmt->bindValue('pseudo', $user->pseudo->value);
        $stmt->execute();

        return $user->created(UserId::from((int) $this->pdo->lastInsertId()));
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $this->instantiate($stmt->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Find all users by their ids
     * The result is an array of User indexed by their ids
     *
     * @param list<int> $ids
     *
     * @return array<int, User>
     */
    public function findAllById(array $ids): array
    {
        // Check that all ids are integers
        (function (int ...$ids) {})(...$ids);

        if (!$ids) {
            return [];
        }

        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id IN (' . str_repeat('?, ', count($ids) - 1) . '?)');
        $stmt->execute($ids); // @todo bind value is better, but takes more lines

        $users = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[$row['id']] = $this->instantiate($row);
        }

        return $users;
    }

    /**
     * @return User
     */
    public function search(?SearchUserCriteria $criteria = null): array
    {
        $query = 'SELECT * FROM user';
        $clauses = [];
        $bindings = [];

        if ($criteria?->username) {
            $clauses[] = 'username LIKE :username';
            $bindings[] = [':username', "%{$criteria->username}%", PDO::PARAM_STR];
        }

        if ($criteria?->pseudo) {
            $clauses[] = 'pseudo LIKE :pseudo';
            $bindings[] = [':pseudo', "%{$criteria->pseudo}%", PDO::PARAM_STR];
        }

        if ($criteria?->id) {
            $clauses[] = 'id = :id';
            $bindings[] = [':id', $criteria->id, PDO::PARAM_INT];
        }

        if ($clauses) {
            $query .= ' WHERE ' . implode($criteria->or ? ' OR ' : ' AND ', $clauses);
        }

        if ($criteria?->offset) {
            $query .= ' OFFSET :offset';
            $bindings[] = [':offset', $criteria->offset, PDO::PARAM_INT];
        }

        if ($criteria?->limit) {
            $query .= ' LIMIT :limit';
            $bindings[] = [':limit', $criteria->limit, PDO::PARAM_INT];
        }

        $stmt = $this->pdo->prepare($query);

        foreach ($bindings as [$name, $value, $type]) {
            $stmt->bindValue($name, $value, $type);
        }

        $stmt->execute();

        $users = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $this->instantiate($row);
        }

        return $users;
    }

    // @todo columns parameter?
    public function update(User $user): bool
    {
        $stmt = $this->pdo->prepare('UPDATE user SET password = :password, pseudo = :pseudo WHERE id = :id');

        $stmt->bindValue('id', $user->id->value, PDO::PARAM_INT);
        $stmt->bindValue('password', $user->password->value);
        $stmt->bindValue('pseudo', $user->pseudo->value);

        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function delete(User $user): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM user WHERE id = :id');
        $stmt->bindValue('id', $user->id->value, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    /**
     * @param array $row
     * @return User
     */
    private function instantiate(array $row): User
    {
        return new User(
            id: UserId::from((int) $row['id']),
            username: Username::from($row['username']),
            password: Password::from($row['password']),
            pseudo: Pseudo::from($row['pseudo']),
        );
    }
}
