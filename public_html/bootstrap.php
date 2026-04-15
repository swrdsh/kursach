<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

session_start();

require_once dirname(__DIR__) . '/db.php';

use App\Repositories\EquipmentRepository;
use App\Repositories\UserRepository;
use App\Services\EquipmentService;
use App\Services\AuthService;
use App\Security\AdminGuard;
use App\Support\SessionManager;
use App\Support\View;

$sessionManager = new SessionManager();
$userRepository = new UserRepository($pdo);
$equipmentRepository = new EquipmentRepository($pdo);
$authService = new AuthService($userRepository, $sessionManager);
$equipmentService = new EquipmentService($equipmentRepository);
$adminGuard = new AdminGuard($authService);
$view = new View($authService);
