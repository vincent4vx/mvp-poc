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
