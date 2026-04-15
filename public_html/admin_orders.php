<?php
declare(strict_types=1);

require __DIR__ . '/check_admin.php';

$view->render('admin_orders', [
    'title' => 'Office Inventory | Заявки',
    'orders' => $orderService->getAdminList(),
]);

