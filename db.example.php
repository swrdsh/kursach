<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Core/Autoloader.php';

use App\Infrastructure\Database;

$config = [
    'host' => 'localhost',
    'database' => 'your_database_name',
    'user' => 'your_database_user',
    'password' => 'your_database_password',
    'charset' => 'utf8mb4',
    'setup_token' => 'change-this-secret-token',
];

$database = new Database($config);
$pdo = $database->getConnection();

