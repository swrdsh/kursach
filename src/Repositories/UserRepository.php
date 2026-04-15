<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class UserRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function existsByEmail(string $email): bool
    {
        $statement = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $statement->execute(['email' => $email]);

        return (int) $statement->fetchColumn() > 0;
    }

    public function create(array $userData): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO users (email, password_hash, username, phone, role)
             VALUES (:email, :password_hash, :username, :phone, :role)'
        );

        $statement->execute([
            'email' => $userData['email'],
            'password_hash' => $userData['password_hash'],
            'username' => $userData['username'],
            'phone' => $userData['phone'],
            'role' => $userData['role'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT id, email, password_hash, username, phone, role, created_at
             FROM users
             WHERE email = :email
             LIMIT 1'
        );
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        return $user === false ? null : $user;
    }

    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT id, email, username, phone, role, created_at
             FROM users
             WHERE id = :id
             LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        $user = $statement->fetch();

        return $user === false ? null : $user;
    }

    public function updatePasswordHash(int $id, string $passwordHash): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE users
             SET password_hash = :password_hash
             WHERE id = :id'
        );

        $statement->execute([
            'id' => $id,
            'password_hash' => $passwordHash,
        ]);
    }
}
