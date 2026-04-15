<?php
declare(strict_types=1);

require __DIR__ . '/check_admin.php';

$view->render('admin_panel', [
    'title' => 'Office Inventory | Админка',
]);

