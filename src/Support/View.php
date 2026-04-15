<?php
declare(strict_types=1);

namespace App\Support;

use App\Services\AuthService;

final class View
{
    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    public function render(string $template, array $params = []): void
    {
        $layoutPath = __DIR__ . '/../Templates/layout.php';
        $templatePath = __DIR__ . '/../Templates/pages/' . $template . '.php';

        if (!is_file($templatePath)) {
            throw new \RuntimeException('Template not found: ' . $template);
        }

        $title = $params['title'] ?? 'Inventory Office';
        $contentData = $params;
        $authService = $this->authService;

        require $layoutPath;
    }
}

