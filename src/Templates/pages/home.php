<?php
declare(strict_types=1);

$user = $authService->getCurrentUser();
$items = $contentData['items'] ?? [];
?>
<section class="hero-card mb-4">
    <div class="row g-4 align-items-center">
        <div class="col-lg-7">
            <span class="hero-badge">Курсовой проект</span>
            <h1 class="display-5 fw-bold mt-3 mb-3">Инвентаризация офисного оборудования</h1>
            <p class="lead text-secondary mb-4">
                Публичная витрина показывает оборудование офиса, а администратор может добавлять новые позиции
                в реестр и управлять наполнением системы через защищенную админ-панель.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <?php if ($user === null): ?>
                    <a class="btn btn-primary btn-lg" href="login.php">Войти</a>
                    <a class="btn btn-outline-secondary btn-lg" href="register.php">Регистрация</a>
                <?php else: ?>
                    <?php if ($authService->isAdmin()): ?>
                        <a class="btn btn-primary btn-lg" href="admin_panel.php">Открыть админку</a>
                        <a class="btn btn-outline-secondary btn-lg" href="add_item.php">Добавить оборудование</a>
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
                    <li>RBAC: админ попадает в закрытую панель, клиент остаётся в публичной части</li>
                    <li>Проверка роли через `check_admin.php` и middleware-guard</li>
                    <li>Таблица `equipment` для инвентарного оборудования офиса</li>
                    <li>Пользователь может оформить заявку на оборудование прямо с витрины</li>
                    <li>Страница `admin_orders.php` собирает заявки через SQL JOIN</li>
                    <li>Безопасный вывод карточек и защита логики от мусорных `id` и повторов</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <h2 class="section-title mb-2">Реестр оборудования</h2>
        <p class="text-secondary mb-0">Новые записи выводятся сверху. Карточки отображаются безопасно, даже если в тексте есть HTML-теги.</p>
    </div>
    <?php if ($authService->isAdmin()): ?>
        <a class="btn btn-outline-primary" href="add_item.php">Добавить новую запись</a>
    <?php endif; ?>
</section>

<section class="row g-4">
    <?php if ($items === []): ?>
        <div class="col-12">
            <div class="empty-state">
                <h3 class="h4 mb-2">Записей пока нет</h3>
                <p class="text-secondary mb-0">Зайдите под администратором и добавьте первое оборудование через админ-панель.</p>
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
                                <a href="admin_orders.php" class="btn btn-outline-secondary">Открыть заявки</a>
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
