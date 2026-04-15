<?php
declare(strict_types=1);

require __DIR__ . '/check_admin.php';

$messageType = '';
$messageText = '';
$old = [
    'inventory_number' => '',
    'title' => '',
    'equipment_type' => '',
    'room_name' => '',
    'responsible_person' => '',
    'purchase_cost' => '',
    'image_url' => '',
    'description' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = [
        'inventory_number' => trim((string) ($_POST['inventory_number'] ?? '')),
        'title' => trim((string) ($_POST['title'] ?? '')),
        'equipment_type' => trim((string) ($_POST['equipment_type'] ?? '')),
        'room_name' => trim((string) ($_POST['room_name'] ?? '')),
        'responsible_person' => trim((string) ($_POST['responsible_person'] ?? '')),
        'purchase_cost' => trim((string) ($_POST['purchase_cost'] ?? '')),
        'image_url' => trim((string) ($_POST['image_url'] ?? '')),
        'description' => trim((string) ($_POST['description'] ?? '')),
    ];

    $result = $equipmentService->create($_POST);
    $messageType = $result['success'] === true ? 'success' : 'error';
    $messageText = $result['message'];

    if ($result['success'] === true) {
        $old = [
            'inventory_number' => '',
            'title' => '',
            'equipment_type' => '',
            'room_name' => '',
            'responsible_person' => '',
            'purchase_cost' => '',
            'image_url' => '',
            'description' => '',
        ];
    }
}

$view->render('add_item', [
    'title' => 'Office Inventory | Добавить запись',
    'messageType' => $messageType,
    'messageText' => $messageText,
    'old' => $old,
]);

