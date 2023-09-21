<?php

namespace Quatrevieux\Mvp\App\User;

use PDO;

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

        if($row === false){
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

    public function create(User $user): User
    {
        $stmt = $this->pdo->prepare('INSERT INTO user (username, password, pseudo) VALUES (:username, :password, :pseudo)');

        $stmt->bindValue('username', $user->username);
        $stmt->bindValue('password', $user->password);
        $stmt->bindValue('pseudo', $user->pseudo);
        $stmt->execute();

        return $this->instantiate([
            'id' => $this->pdo->lastInsertId(),
            'username' => $user->username,
            'password' => $user->password,
            'pseudo' => $user->pseudo,
        ]);
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $this->instantiate($stmt->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * @param array $row
     * @return User
     */
    public function instantiate(array $row): User
    {
        return new User(
            id: $row['id'],
            username: $row['username'],
            password: $row['password'],
            pseudo: $row['pseudo'],
        );
    }

}
