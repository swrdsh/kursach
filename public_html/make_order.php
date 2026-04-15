<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if (!$authService->isAuthenticated()) {
    header('Location: login.php');
    exit;
}

$equipmentId = (int) ($_GET['id'] ?? 0);
$currentUser = $authService->getCurrentUser();

if ($currentUser === null) {
    $authService->logout();
    header('Location: login.php');
    exit;
}

$result = $orderService->placeOrder((int) $currentUser['id'], $equipmentId);

$view->render('order_result', [
    'title' => 'Office Inventory | Оформление заявки',
    'result' => $result,
    'equipment' => $result['equipment'] ?? null,
]);
