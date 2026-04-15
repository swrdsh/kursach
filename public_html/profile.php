<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if (!$authService->isAuthenticated()) {
    header('Location: login.php');
    exit;
}

$currentUser = $authService->getCurrentUser();

if ($currentUser === null) {
    $authService->logout();
    header('Location: login.php');
    exit;
}

$view->render('profile', [
    'title' => 'Office Inventory | Профиль',
    'user' => $currentUser,
]);
