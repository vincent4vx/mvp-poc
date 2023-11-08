<?php

namespace Quatrevieux\Mvp\Backend\Domain\Security;

use DateTimeImmutable;
use DateTimeInterface;
use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Domain\UserRole;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;
use RuntimeException;

use function hash_equals;
use function hash_hmac;

final class AuthenticatedUser
{
    private function __construct(
        public readonly UserId $id,
        public readonly Username $username,
        public readonly Pseudo $pseudo,
        public readonly UserRolesSet $roles,
        public readonly DateTimeInterface $date,
        private readonly string $key,
        private readonly ?DateTimeInterface $adminSessionExpiration,
        string $pepper,
    ) {
        $this->checkKey($pepper);
        $this->checkDate();
    }

    public function isAdminSession(): bool
    {
        return $this->adminSessionExpiration && $this->adminSessionExpiration > new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value,
            'username' => $this->username->value,
            'pseudo' => $this->pseudo->value,
            'roles' => $this->roles->value,
            'date' => $this->date->format(DateTimeInterface::ATOM),
            'adminSessionExpiration' => $this->adminSessionExpiration?->format(DateTimeInterface::ATOM),
            'key' => $this->key,
        ];
    }

    public static function fromArray(array $data, string $pepper): self
    {
        if ($adminSessionExpiration = ($data['adminSessionExpiration'] ?? null)) {
            $adminSessionExpiration = new DateTimeImmutable($adminSessionExpiration);
        } else {
            $adminSessionExpiration = null;
        }

        return new self(
            id: UserId::from($data['id']),
            username: Username::from($data['username']),
            pseudo: Pseudo::from($data['pseudo']),
            roles: UserRolesSet::from($data['roles']),
            date: new DateTimeImmutable($data['date']),
            key: $data['key'],
            adminSessionExpiration: $adminSessionExpiration,
            pepper: $pepper,
        );
    }

    public static function create(User $user, string $inputPassword, string $pepper): ?self
    {
        return self::createAdminSession($user, null, $inputPassword, $pepper);
    }

    public static function createAdminSession(User $user, ?DateTimeInterface $adminSessionExpiration, string $inputPassword, string $pepper): ?self
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
            key: self::computeKey($pepper, $user->id, $user->username, $user->pseudo, $user->roles, $date, $adminSessionExpiration),
            adminSessionExpiration: $adminSessionExpiration,
            pepper: $pepper,
        );
    }

    private function checkKey(string $pepper): void
    {
        if (!hash_equals($this->key, self::computeKey($pepper, $this->id, $this->username, $this->pseudo, $this->roles, $this->date, $this->adminSessionExpiration))) {
            throw new RuntimeException('Invalid key');
        }
    }

    private function checkDate(): void
    {
        if ($this->date > new DateTimeImmutable()) {
            throw new RuntimeException('Invalid date');
        }
    }

    private static function computeKey(string $pepper, UserId $id, Username $username, Pseudo $pseudo, UserRolesSet $roles, DateTimeInterface $date, ?DateTimeInterface $adminSessionExpiration): string
    {
        return hash_hmac(
            'sha256',
            $id->value . $username->value . $pseudo->value . $roles->value . $date->getTimestamp() . ($adminSessionExpiration?->getTimestamp() ?? ''),
            $pepper,
        );
    }
}
