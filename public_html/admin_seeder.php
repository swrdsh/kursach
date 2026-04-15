<?php
declare(strict_types=1);

require __DIR__ . '/check_admin.php';

use App\Services\SeederService;

$seederService = new SeederService($equipmentRepository, __DIR__ . '/exports');
$tables = $seederService->getAvailableTables();
$messageText = '';
$messageType = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], (string) ($_POST['csrf_token'] ?? ''))) {
        http_response_code(403);
        exit('CSRF Attack blocked');
    }

    $tableName = trim((string) ($_POST['table_name'] ?? ''));
    $count = max(1, (int) ($_POST['count'] ?? 10));

    if (!in_array($tableName, $tables, true)) {
        $messageText = 'Ошибка: таблица не найдена.';
        $messageType = 'danger';
    } else {
        $result = $seederService->seedEquipment($count);
        $messageType = $result['success'] ? 'success' : 'danger';
        $messageText = $result['message'];

        if ($result['success']) {
            $messageText .= ' Бэкап: ' . $result['backup_file'] . '. Сгенерировано: ' . $result['inserted'] . ' из ' . $result['requested'] . '.';
        }
    }
}

$view->render('admin_seeder', [
    'title' => 'Office Inventory | Генератор данных',
    'tables' => $tables,
    'messageText' => $messageText,
    'messageType' => $messageType,
    'csrfToken' => $_SESSION['csrf_token'],
]);

