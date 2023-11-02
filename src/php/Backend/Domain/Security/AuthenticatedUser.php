<?php

namespace Quatrevieux\Mvp\Backend\Domain\Security;

use DateTimeImmutable;
use DateTimeInterface;
use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;
use RuntimeException;

use function hash_equals;
use function hash_hmac;

final class AuthenticatedUser
{
    private const KEY_PEPPER = 'pepper';

    private function __construct(
        public readonly UserId $id,
        public readonly Username $username,
        public readonly Pseudo $pseudo,
        public readonly UserRolesSet $roles,
        public readonly DateTimeInterface $date,
        private readonly string $key,
    ) {
        $this->checkKey();
        $this->checkDate();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value,
            'username' => $this->username->value,
            'pseudo' => $this->pseudo->value,
            'roles' => $this->roles->value,
            'date' => $this->date->format(DateTimeInterface::ATOM),
            'key' => $this->key,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: UserId::from($data['id']),
            username: Username::from($data['username']),
            pseudo: Pseudo::from($data['pseudo']),
            roles: UserRolesSet::from($data['roles']),
            date: new DateTimeImmutable($data['date']),
            key: $data['key'],
        );
    }

    public static function create(User $user, string $inputPassword): ?self
    {
        if (!$user->password->verify($inputPassword)) {
            return null;
        }

        return new self(
            id: $user->id,
            username: $user->username,
            pseudo: $user->pseudo,
            roles: $user->roles,
            date: $date = new DateTimeImmutable(),
            key: self::computeKey($user->id, $user->username, $user->pseudo, $user->roles, $date),
        );
    }

    private function checkKey(): void
    {
        if (!hash_equals($this->key, self::computeKey($this->id, $this->username, $this->pseudo, $this->roles, $this->date))) {
            throw new RuntimeException('Invalid key');
        }
    }

    private function checkDate(): void
    {
        if ($this->date > new DateTimeImmutable()) {
            throw new RuntimeException('Invalid date');
        }
    }

    private static function computeKey(UserId $id, Username $username, Pseudo $pseudo, UserRolesSet $roles, DateTimeInterface $date): string
    {
        return hash_hmac(
            'sha256',
            $id->value . $username->value . $pseudo->value . $roles->value . $date->getTimestamp(),
            self::KEY_PEPPER,
        );
    }
}
