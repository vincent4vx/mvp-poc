<?php

namespace Quatrevieux\Mvp\Backend\User;

use PDO;
use Quatrevieux\Mvp\Backend\User\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\ValueObject\Username;

use function count;
use function str_repeat;

class UserRepository
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
     * @param array $row
     * @return User
     */
    public function instantiate(array $row): User
    {
        return new User(
            id: UserId::from((int) $row['id']),
            username: Username::from($row['username']),
            password: Password::from($row['password']),
            pseudo: Pseudo::from($row['pseudo']),
        );
    }
}
