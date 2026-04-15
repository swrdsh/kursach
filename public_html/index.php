<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$items = $equipmentService->getLatest();

$view->render('home', [
    'title' => 'Office Inventory | Главная',
    'items' => $items,
]);
