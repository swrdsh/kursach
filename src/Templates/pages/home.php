<?php
declare(strict_types=1);

$user = $authService->getCurrentUser();
$items = $contentData['items'] ?? [];
$page = (int) ($contentData['page'] ?? 1);
$totalPages = (int) ($contentData['totalPages'] ?? 1);
$totalRows = (int) ($contentData['totalRows'] ?? 0);
$search = (string) ($contentData['search'] ?? '');
?>
<section class="hero-panel">
    <div class="hero-panel__content">
        <span class="eyebrow">Инвентаризация офиса</span>
        <h1 class="hero-title">Единый реестр техники, заявок и ответственных лиц</h1>
        <p class="hero-copy">
            Система помогает учитывать офисное оборудование, фиксировать его местоположение,
            видеть ответственных сотрудников и принимать заявки от пользователей через единый веб-интерфейс.
        </p>
        <div class="hero-actions">
            <?php if ($user === null): ?>
                <a class="btn btn-primary btn-lg" href="login.php">Войти в систему</a>
                <a class="btn btn-outline-dark btn-lg" href="register.php">Создать аккаунт</a>
            <?php else: ?>
                <?php if ($authService->isAdmin()): ?>
                    <a class="btn btn-primary btn-lg" href="manage_items.php">Открыть управление</a>
                    <a class="btn btn-outline-dark btn-lg" href="admin_panel.php">Перейти в админку</a>
                <?php else: ?>
                    <a class="btn btn-primary btn-lg" href="profile.php">Перейти в профиль</a>
                    <a class="btn btn-outline-dark btn-lg" href="logout.php">Выйти</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <aside class="hero-panel__stats">
        <div class="stat-card">
            <span class="stat-card__label">Всего записей</span>
            <strong class="stat-card__value"><?= h((string) $totalRows) ?></strong>
        </div>
        <div class="stat-card">
            <span class="stat-card__label">Страница</span>
            <strong class="stat-card__value"><?= h((string) $page) ?> / <?= h((string) $totalPages) ?></strong>
        </div>
        <div class="stat-card">
            <span class="stat-card__label">Функции</span>
            <strong class="stat-card__value">CRUD + JOIN + QR</strong>
        </div>
    </aside>
</section>

<section class="search-panel">
    <div class="search-panel__head">
        <div>
            <span class="eyebrow eyebrow--dark">Каталог оборудования</span>
            <h2 class="section-title">Поиск и постраничный просмотр</h2>
        </div>
        <?php if ($authService->isAdmin()): ?>
            <div class="hero-actions">
                <a class="btn btn-outline-dark" href="add_item.php">Добавить запись</a>
                <a class="btn btn-outline-dark" href="manage_items.php">Редактировать</a>
            </div>
        <?php endif; ?>
    </div>

    <form method="GET" action="index.php" class="search-form">
        <div class="search-form__field">
            <label for="q" class="form-label">Поиск по реестру</label>
            <input id="q" type="text" name="q" class="form-control" value="<?= h($search) ?>" placeholder="Инвентарный номер, кабинет, тип техники, ответственное лицо">
        </div>
        <div class="search-form__actions">
            <button type="submit" class="btn btn-primary">Найти</button>
            <a href="index.php" class="btn btn-outline-dark">Сбросить</a>
        </div>
    </form>
</section>

<section class="catalog-grid">
    <?php if ($items === []): ?>
        <div class="empty-state">
            <h3 class="empty-state__title">По вашему запросу ничего не найдено</h3>
            <p class="empty-state__text">Измените критерии поиска или добавьте новое оборудование через административный раздел.</p>
        </div>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <article class="catalog-card">
                <div class="catalog-card__image-wrap">
                    <img
                        src="<?= h((string) ($item['image_url'] ?: 'https://placehold.co/900x600/f4efe5/2d2418?text=Inventory')) ?>"
                        alt="<?= h((string) $item['title']) ?>"
                        class="catalog-card__image"
                    >
                    <span class="catalog-card__badge"><?= h((string) ($item['equipment_type'] ?: 'Тип не указан')) ?></span>
                </div>

                <div class="catalog-card__body">
                    <div class="catalog-card__topline">
                        <span class="catalog-card__inventory"><?= h((string) $item['inventory_number']) ?></span>
                        <span class="catalog-card__cost"><?= h((string) ($item['purchase_cost'] !== null ? $item['purchase_cost'] . ' ₽' : 'Без цены')) ?></span>
                    </div>

                    <h3 class="catalog-card__title"><?= h((string) $item['title']) ?></h3>
                    <p class="catalog-card__description"><?= h((string) ($item['description'] ?: 'Описание отсутствует.')) ?></p>

                    <dl class="catalog-card__meta">
                        <div>
                            <dt>Кабинет</dt>
                            <dd><?= h((string) ($item['room_name'] ?: 'Не указан')) ?></dd>
                        </div>
                        <div>
                            <dt>Ответственный</dt>
                            <dd><?= h((string) ($item['responsible_person'] ?: 'Не назначен')) ?></dd>
                        </div>
                    </dl>

                    <div class="catalog-card__actions">
                        <a href="make_order.php?id=<?= h((string) $item['id']) ?>" class="btn btn-primary">Оформить заявку</a>
                        <?php if ($user === null): ?>
                            <a href="login.php" class="btn btn-outline-dark">Войти</a>
                        <?php elseif ($authService->isAdmin()): ?>
                            <a href="edit_item.php?id=<?= h((string) $item['id']) ?>" class="btn btn-outline-dark">Изменить</a>
                        <?php else: ?>
                            <a href="profile.php" class="btn btn-outline-dark">Профиль</a>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php if ($totalPages > 1): ?>
    <nav class="pagination-wrap">
        <ul class="pagination pagination-store justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($search) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
