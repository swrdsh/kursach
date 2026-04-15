<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if ($authService->isAuthenticated()) {
    header('Location: profile.php');
    exit;
}

$errorMessage = '';
$successMessage = '';
$old = [
    'email' => '',
    'username' => '',
    'phone' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = [
        'email' => trim((string) ($_POST['email'] ?? '')),
        'username' => trim((string) ($_POST['username'] ?? '')),
        'phone' => trim((string) ($_POST['phone'] ?? '')),
    ];

    $result = $authService->register($_POST);

    if ($result['success'] === true) {
        $successMessage = $result['message'];
        $old = [
            'email' => '',
            'username' => '',
            'phone' => '',
        ];
    } else {
        $errorMessage = $result['message'];
    }
}

$view->render('register', [
    'title' => 'Office Inventory | Регистрация',
    'errorMessage' => $errorMessage,
    'successMessage' => $successMessage,
    'old' => $old,
]);

