<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$page = max(1, (int) ($_GET['page'] ?? 1));
$search = trim((string) ($_GET['q'] ?? ''));
$catalog = $equipmentService->getCatalogPage($page, 10, $search);

$view->render('home', [
    'title' => 'Office Inventory | Главная',
    'items' => $catalog['items'],
    'page' => $catalog['page'],
    'totalPages' => $catalog['total_pages'],
    'totalRows' => $catalog['total_rows'],
    'search' => $catalog['search'],
]);

