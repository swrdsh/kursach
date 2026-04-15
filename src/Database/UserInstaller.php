<?php
declare(strict_types=1);

namespace App\Database;

use PDO;

final class UserInstaller
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly string $schemaPath
    ) {
    }

    public function install(): array
    {
        $statements = $this->readStatements();

        foreach ($statements as $statement) {
            $this->pdo->exec($statement);
        }

        $seededUsers = $this->seedDefaultUsers();

        return [
            'statements_executed' => count($statements),
            'seeded_users' => $seededUsers,
        ];
    }

    private function readStatements(): array
    {
        $schema = file_get_contents($this->schemaPath);

        if ($schema === false) {
            throw new \RuntimeException('Не удалось прочитать schema.sql');
        }

        $statements = array_filter(array_map(
            static fn (string $statement): string => trim($statement),
            explode(';', $schema)
        ));

        return array_values($statements);
    }

    private function seedDefaultUsers(): array
    {
        $users = [
            [
                'email' => 'admin@shop.local',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'username' => 'Главный Админ',
                'phone' => null,
                'role' => 'admin',
            ],
            [
                'email' => 'client@shop.local',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'username' => 'Тестовый Клиент',
                'phone' => null,
                'role' => 'client',
            ],
        ];

        $statement = $this->pdo->prepare(
            'INSERT INTO users (email, password_hash, username, phone, role)
             VALUES (:email, :password_hash, :username, :phone, :role)'
        );

        foreach ($users as $user) {
            $statement->execute($user);
        }

        return [
            'admin' => [
                'email' => 'admin@shop.local',
                'password' => 'admin123',
            ],
            'client' => [
                'email' => 'client@shop.local',
                'password' => 'admin123',
            ],
        ];
    }
}

