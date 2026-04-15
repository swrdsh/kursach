<?php
declare(strict_types=1);

require __DIR__ . '/check_admin.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

if (!hash_equals($_SESSION['csrf_token'], (string) ($_POST['csrf_token'] ?? ''))) {
    header('Location: manage_items.php?error=csrf');
    exit;
}

$id = max(0, (int) ($_POST['id'] ?? 0));
$reason = trim((string) ($_POST['writeoff_reason'] ?? ''));
$currentUser = $authService->getCurrentUser();
$result = $equipmentService->delete($id, $reason, $currentUser !== null ? (int) $currentUser['id'] : null);

if ($result['success'] === true) {
    header('Location: manage_items.php?deleted=1');
    exit;
}

header('Location: manage_items.php?error=delete&message=' . urlencode($result['message']));
exit;

