<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if ($authService->isAuthenticated()) {
    header('Location: profile.php');
    exit;
}

$errorMessage = '';
$old = ['email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = [
        'email' => trim((string) ($_POST['email'] ?? '')),
    ];

    $result = $authService->login($_POST);

    if ($result['success'] === true) {
        if ($authService->isAdmin()) {
            header('Location: admin_panel.php');
        } else {
            header('Location: index.php');
        }
        exit;
    }

    $errorMessage = $result['message'];
}

$view->render('login', [
    'title' => 'Office Inventory | Вход',
    'errorMessage' => $errorMessage,
    'old' => $old,
]);
