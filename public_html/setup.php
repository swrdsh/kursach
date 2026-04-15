<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

use App\Database\UserInstaller;

$providedToken = (string) ($_GET['token'] ?? '');
$expectedToken = (string) ($config['setup_token'] ?? '');

if ($providedToken === '' || $expectedToken === '' || !hash_equals($expectedToken, $providedToken)) {
    http_response_code(403);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        'success' => false,
        'message' => 'Forbidden',
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$installer = new UserInstaller($pdo, dirname(__DIR__) . '/database/schema.sql');
$result = $installer->install();

header('Content-Type: application/json; charset=UTF-8');
echo json_encode([
    'success' => true,
    'message' => 'Таблица users создана, тестовые пользователи добавлены.',
    'details' => $result,
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

