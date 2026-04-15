<?php
declare(strict_types=1);

require __DIR__ . '/check_admin.php';

$page = max(1, (int) ($_GET['page'] ?? 1));
$search = trim((string) ($_GET['q'] ?? ''));
$catalog = $equipmentService->getCatalogPage($page, 10, $search);

$flashMessage = '';
$flashType = 'info';
if (isset($_GET['updated'])) {
    $flashMessage = 'Изменения сохранены.';
    $flashType = 'success';
} elseif (isset($_GET['deleted'])) {
    $flashMessage = 'Оборудование списано.';
    $flashType = 'success';
} elseif (isset($_GET['error']) && $_GET['error'] === 'csrf') {
    $flashMessage = 'CSRF Attack blocked';
    $flashType = 'danger';
} elseif (isset($_GET['error']) && $_GET['error'] === 'delete') {
    $flashMessage = trim((string) ($_GET['message'] ?? 'Не удалось удалить запись.'));
    $flashType = 'danger';
}

$view->render('manage_items', [
    'title' => 'Office Inventory | Управление оборудованием',
    'items' => $catalog['items'],
    'page' => $catalog['page'],
    'totalPages' => $catalog['total_pages'],
    'totalRows' => $catalog['total_rows'],
    'search' => $catalog['search'],
    'csrfToken' => $_SESSION['csrf_token'],
    'flashMessage' => $flashMessage,
    'flashType' => $flashType,
]);

