<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once dirname(__DIR__) . '/db.php';

use App\Repositories\EquipmentHistoryRepository;
use App\Repositories\EquipmentRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Services\EquipmentService;
use App\Services\AuthService;
use App\Services\OrderService;
use App\Security\AdminGuard;
use App\Support\SessionManager;
use App\Support\View;

$sessionManager = new SessionManager();
$userRepository = new UserRepository($pdo);
$equipmentRepository = new EquipmentRepository($pdo);
$equipmentHistoryRepository = new EquipmentHistoryRepository($pdo);
$orderRepository = new OrderRepository($pdo);
$authService = new AuthService($userRepository, $sessionManager);
$equipmentService = new EquipmentService($equipmentRepository, $equipmentHistoryRepository);
$orderService = new OrderService($orderRepository, $equipmentRepository);
$adminGuard = new AdminGuard($authService);
$view = new View($authService);

