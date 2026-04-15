<?php
declare(strict_types=1);

$user = $authService->getCurrentUser();
$items = $contentData['items'] ?? [];
$page = (int) ($contentData['page'] ?? 1);
$totalPages = (int) ($contentData['totalPages'] ?? 1);
$totalRows = (int) ($contentData['totalRows'] ?? 0);
$search = (string) ($contentData['search'] ?? '');
?>
<section class="hero-card mb-4">
    <div class="row g-4 align-items-center">
        <div class="col-lg-7">
            <span class="hero-badge">Курсовой проект</span>
            <h1 class="display-5 fw-bold mt-3 mb-3">Инвентаризация офисного оборудования</h1>
            <p class="lead text-secondary mb-4">
                Публичная витрина показывает оборудование офиса, а администратор получает полный контроль:
                добавление, редактирование, списание, поиск и постраничный вывод данных.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <?php if ($user === null): ?>
                    <a class="btn btn-primary btn-lg" href="login.php">Войти</a>
                    <a class="btn btn-outline-secondary btn-lg" href="register.php">Регистрация</a>
                <?php else: ?>
                    <?php if ($authService->isAdmin()): ?>
                        <a class="btn btn-primary btn-lg" href="manage_items.php">Управлять оборудованием</a>
                        <a class="btn btn-outline-secondary btn-lg" href="admin_seeder.php">Сидер данных</a>
                    <?php else: ?>
                        <a class="btn btn-primary btn-lg" href="profile.php">Открыть профиль</a>
                        <a class="btn btn-outline-secondary btn-lg" href="logout.php">Выйти</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="info-panel">
                <h2 class="h4 mb-3">Что уже готово</h2>
                <ul class="feature-list mb-0">
                    <li>Полный CRUD для оборудования с админским доступом</li>
                    <li>Безопасное удаление через POST, CSRF и подтверждение списания</li>
                    <li>Публичная витрина с поиском и пагинацией по 10 записей</li>
                    <li>Заявки пользователей и административная таблица на JOIN</li>
                    <li>Генератор тестовых данных с CSV-бэкапом для стресс-теста</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="card border-0 shadow-lg mb-4">
    <div class="card-body p-4">
        <form method="GET" action="index.php" class="row g-3 align-items-end">
            <div class="col-lg-8">
                <label for="q" class="form-label">Поиск по реестру</label>
                <input id="q" type="text" name="q" class="form-control" value="<?= h($search) ?>" placeholder="Инвентарный номер, название, кабинет, МОЛ...">
            </div>
            <div class="col-lg-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Найти</button>
                <a href="index.php" class="btn btn-outline-secondary">Сбросить</a>
            </div>
        </form>
    </div>
</section>

<section class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <h2 class="section-title mb-2">Реестр оборудования</h2>
        <p class="text-secondary mb-0">Всего записей: <?= h((string) $totalRows) ?>. На странице выводится по 10 карточек.</p>
    </div>
    <?php if ($authService->isAdmin()): ?>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-outline-primary" href="add_item.php">Добавить запись</a>
            <a class="btn btn-outline-secondary" href="manage_items.php">Редактировать</a>
        </div>
    <?php endif; ?>
</section>

<section class="row g-4">
    <?php if ($items === []): ?>
        <div class="col-12">
            <div class="empty-state">
                <h3 class="h4 mb-2">Записи не найдены</h3>
                <p class="text-secondary mb-0">Попробуйте изменить поисковый запрос или добавьте новое оборудование.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="col-md-6 col-xl-4">
                <article class="equipment-card h-100">
                    <img
                        src="<?= h((string) ($item['image_url'] ?: 'https://placehold.co/900x600/e9eef6/1f2937?text=Equipment')) ?>"
                        alt="<?= h((string) $item['title']) ?>"
                        class="equipment-card__image"
                    >
                    <div class="equipment-card__body">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <span class="equipment-chip"><?= h((string) ($item['equipment_type'] ?: 'Тип не указан')) ?></span>
                            <span class="equipment-id"><?= h((string) $item['inventory_number']) ?></span>
                        </div>
                        <h3 class="h5 mb-2"><?= h((string) $item['title']) ?></h3>
                        <p class="text-secondary mb-3"><?= h((string) ($item['description'] ?: 'Описание отсутствует.')) ?></p>
                        <div class="equipment-meta">
                            <div><strong>Кабинет:</strong> <?= h((string) ($item['room_name'] ?: 'Не указан')) ?></div>
                            <div><strong>МОЛ:</strong> <?= h((string) ($item['responsible_person'] ?: 'Не назначено')) ?></div>
                            <div><strong>Стоимость:</strong> <?= h((string) ($item['purchase_cost'] !== null ? $item['purchase_cost'] . ' ₽' : 'Не указана')) ?></div>
                        </div>
                        <div class="mt-4 d-flex flex-wrap gap-2">
                            <a href="make_order.php?id=<?= h((string) $item['id']) ?>" class="btn btn-primary">Оформить заявку</a>
                            <?php if ($user === null): ?>
                                <a href="login.php" class="btn btn-outline-secondary">Войти</a>
                            <?php elseif ($authService->isAdmin()): ?>
                                <a href="edit_item.php?id=<?= h((string) $item['id']) ?>" class="btn btn-outline-secondary">Редактировать</a>
                            <?php else: ?>
                                <a href="profile.php" class="btn btn-outline-secondary">Профиль</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php if ($totalPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination pagination-store justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($search) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>

