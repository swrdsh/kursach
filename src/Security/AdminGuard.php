<?php
declare(strict_types=1);

namespace App\Security;

use App\Services\AuthService;

final class AdminGuard
{
    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    public function enforce(): void
    {
        if ($this->authService->isAdmin()) {
            return;
        }

        http_response_code(403);
        echo '<!doctype html><html lang="ru"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Доступ запрещён</title><link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet"><style>body{margin:0;font-family:Manrope,sans-serif;background:linear-gradient(180deg,#fbf6ef 0%,#f4efe5 100%);color:#2d2418}.wrap{min-height:100vh;display:grid;place-items:center;padding:24px}.card{max-width:560px;background:rgba(255,250,242,.94);border:1px solid rgba(83,62,42,.12);border-radius:32px;padding:32px;box-shadow:0 24px 60px rgba(77,53,29,.12)}.badge{display:inline-flex;padding:8px 14px;border-radius:999px;background:rgba(191,91,44,.12);color:#8e3f19;font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}.title{margin:16px 0 12px;font-size:34px;line-height:1}.copy{margin:0 0 24px;color:#73624d;line-height:1.7}.btn{display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:0 22px;border-radius:999px;background:#bf5b2c;color:#fff;text-decoration:none;font-weight:800}</style></head><body><div class="wrap"><div class="card"><span class="badge">403</span><h1 class="title">Доступ запрещён</h1><p class="copy">У вас нет прав администратора для перехода на эту страницу. Войдите под учётной записью администратора или вернитесь в общий раздел сайта.</p><a class="btn" href="login.php">Перейти ко входу</a></div></div></body></html>';
        exit;
    }
}
