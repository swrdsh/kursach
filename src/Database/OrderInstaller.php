<?php
declare(strict_types=1);

namespace App\Database;

use PDO;

final class OrderInstaller
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly string $schemaPath
    ) {
    }

    public function install(): array
    {
        $schema = file_get_contents($this->schemaPath);

        if ($schema === false) {
            throw new \RuntimeException('Не удалось прочитать orders.sql');
        }

        $statements = array_values(array_filter(array_map(
            static fn (string $statement): string => trim($statement),
            explode(';', $schema)
        )));

        foreach ($statements as $statement) {
            $this->pdo->exec($statement);
        }

        return [
            'statements_executed' => count($statements),
            'table' => 'orders',
        ];
    }
}

