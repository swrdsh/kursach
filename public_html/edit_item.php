<?php
declare(strict_types=1);

require __DIR__ . '/check_admin.php';

$id = max(0, (int) ($_GET['id'] ?? $_POST['id'] ?? 0));
$item = $equipmentService->findById($id);

if ($item === null) {
    http_response_code(404);
    exit('Оборудование не найдено.');
}

$messageType = '';
$messageText = '';
$old = $item;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], (string) ($_POST['csrf_token'] ?? ''))) {
        http_response_code(403);
        exit('CSRF Attack blocked');
    }

    $old = [
        'id' => $id,
        'inventory_number' => trim((string) ($_POST['inventory_number'] ?? '')),
        'title' => trim((string) ($_POST['title'] ?? '')),
        'equipment_type' => trim((string) ($_POST['equipment_type'] ?? '')),
        'room_name' => trim((string) ($_POST['room_name'] ?? '')),
        'responsible_person' => trim((string) ($_POST['responsible_person'] ?? '')),
        'purchase_cost' => trim((string) ($_POST['purchase_cost'] ?? '')),
        'image_url' => trim((string) ($_POST['image_url'] ?? '')),
        'description' => trim((string) ($_POST['description'] ?? '')),
    ];

    $currentUser = $authService->getCurrentUser();
    $result = $equipmentService->update($id, $_POST, $currentUser !== null ? (int) $currentUser['id'] : null);

    if ($result['success'] === true) {
        header('Location: manage_items.php?updated=1');
        exit;
    }

    $messageType = 'error';
    $messageText = $result['message'];
}

$view->render('equipment_form', [
    'title' => 'Office Inventory | Редактировать оборудование',
    'mode' => 'edit',
    'heading' => 'Редактирование оборудования',
    'descriptionText' => 'Измените данные выбранной записи и сохраните правки.',
    'formAction' => 'edit_item.php?id=' . $id,
    'submitLabel' => 'Обновить запись',
    'backLink' => 'manage_items.php',
    'messageType' => $messageType,
    'messageText' => $messageText,
    'old' => $old,
    'csrfToken' => $_SESSION['csrf_token'],
]);

