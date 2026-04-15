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
        echo '<!doctype html><html lang="ru"><head><meta charset="UTF-8"><title>Доступ запрещен</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light"><div class="container py-5"><div class="alert alert-danger shadow-sm"><h1 class="h3 mb-3">Доступ запрещен</h1><p class="mb-3">У вас нет прав администратора для доступа к этой странице.</p><a class="btn btn-primary" href="login.php">Войти</a></div></div></body></html>';
        exit;
    }
}

