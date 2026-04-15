<?php
declare(strict_types=1);

namespace App\Infrastructure;

use PDO;
use PDOException;

final class Database
{
    public function __construct(
        private readonly array $config
    ) {
    }

    public function getConnection(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return new PDO(
                $dsn,
                $this->config['user'],
                $this->config['password'],
                $options
            );
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage(), (int) $exception->getCode());
        }
    }
}

