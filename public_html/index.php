<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$view->render('home', [
    'title' => 'Office Inventory | Главная',
]);

