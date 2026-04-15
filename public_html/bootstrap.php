<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

session_start();

require_once dirname(__DIR__) . '/db.php';

use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Support\SessionManager;
use App\Support\View;

$sessionManager = new SessionManager();
$userRepository = new UserRepository($pdo);
$authService = new AuthService($userRepository, $sessionManager);
$view = new View($authService);
