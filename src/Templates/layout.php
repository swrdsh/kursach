<?php
declare(strict_types=1);

$currentUser = $authService->getCurrentUser();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
</head>
<body>
    <div class="site-backdrop"></div>
    <div class="page-shell">
        <header class="topbar">
            <div class="container">
                <div class="topbar__inner">
                    <a class="brand-mark" href="index.php">
                        <span class="brand-mark__badge">OI</span>
                        <span class="brand-mark__text">Office Inventory</span>
                    </a>

                    <nav class="main-nav">
                        <a class="main-nav__link" href="index.php">Главная</a>
                        <?php if ($currentUser === null): ?>
                            <a class="main-nav__link" href="login.php">Вход</a>
                            <a class="main-nav__link" href="register.php">Регистрация</a>
                        <?php else: ?>
                            <?php if ($authService->isAdmin()): ?>
                                <a class="main-nav__link" href="admin_panel.php">Админка</a>
                                <a class="main-nav__link" href="manage_items.php">Оборудование</a>
                                <a class="main-nav__link" href="admin_orders.php">Заявки</a>
                                <a class="main-nav__link" href="admin_seeder.php">Сидер</a>
                            <?php endif; ?>
                            <a class="main-nav__link" href="profile.php">Профиль</a>
                            <a class="main-nav__link main-nav__link--accent" href="logout.php">Выход</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </header>

        <main class="page-main">
            <div class="container">
                <?php require $templatePath; ?>
            </div>
        </main>
    </div>
</body>
</html>
