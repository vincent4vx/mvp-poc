<?php

namespace Quatrevieux\Mvp\Backend\User\Infrastructure\PDO;

use PDO;
use Quatrevieux\Mvp\Backend\User\Domain\ModifiedUser;
use Quatrevieux\Mvp\Backend\User\Domain\SearchUserCriteria;
use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Domain\UserCreation;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Domain\UsersSearchResult;
use Quatrevieux\Mvp\Backend\User\Domain\UserWriteRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;

use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;

use function array_column;
use function count;
use function DI\value;
use function implode;
use function in_array;
use function str_contains;
use function str_repeat;
use function str_replace;
use function substr;

class UserWriteRepository implements UserWriteRepositoryInterface
{
    private const ATTRIBUTES = [
        'id' => 'id',
        'username' => 'username',
        'password' => 'password',
        'pseudo' => 'pseudo',
        'roles' => 'roles',
    ];

    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    public function create(UserCreation $user): User
    {
        $stmt = $this->pdo->prepare('INSERT INTO user (username, password, pseudo, roles) VALUES (:username, :password, :pseudo, :roles)');

        $stmt->bindValue('username', $user->username->value);
        $stmt->bindValue('password', $user->password->value);
        $stmt->bindValue('pseudo', $user->pseudo->value);
        $stmt->bindValue('roles', $user->roles->value, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            $this->handleException($e);
        }

        return $user->created(UserId::from((int) $this->pdo->lastInsertId()));
    }

    public function update(ModifiedUser $user): ?User
    {
        $bindings = ['id' => $user->id->value];

        foreach ($user->modifiedFields as $field) {
            $bindings[self::ATTRIBUTES[$field->value]] = $field->value($user)->value();
        }

        $stmt = $this->pdo->prepare('UPDATE user SET ' . implode(', ', array_map(fn ($column) => "$column = :$column", array_keys($bindings))) . ' WHERE id = :id');

        try {
            $stmt->execute($bindings);
        } catch (\PDOException $e) {
            $this->handleException($e);
        }

        if ($stmt->rowCount() === 1) {
            return $user->saved();
        }

        return null;
    }

    public function delete(User $user): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM user WHERE id = :id');
        $stmt->bindValue('id', $user->id->value, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    private function handleException(\PDOException $e)
    {
        $code = substr($e->errorInfo[0], 0, 2);

        if (in_array($code, ['22', '23'], true)) {
            $message = $e->getMessage();
            $type = InvalidDataErrorType::fromMysqlErrorCode($e->errorInfo[1]);

            foreach (self::ATTRIBUTES as $db => $php) {
                if (str_contains($message, "'$db'")) {
                    throw new InvalidDataException($type, $php, $message);
                }
            }
        }

        throw $e;
    }
}
