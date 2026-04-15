<?php
declare(strict_types=1);
?>
<section class="admin-hero mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <span class="eyebrow eyebrow--dark">RBAC</span>
            <h1 class="display-6 fw-bold mt-3 mb-2">Панель администратора</h1>
            <p class="text-secondary mb-0">Закрытая зона для управления инвентаризацией, заявками и тестовыми данными.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="add_item.php" class="btn btn-primary">Добавить запись</a>
            <a href="manage_items.php" class="btn btn-outline-primary">Управление</a>
            <a href="admin_orders.php" class="btn btn-outline-primary">Заявки</a>
            <a href="admin_seeder.php" class="btn btn-outline-secondary">Сидер</a>
            <a href="index.php" class="btn btn-outline-secondary">На главную</a>
            <a href="logout.php" class="btn btn-outline-danger">Выйти</a>
        </div>
    </div>
</section>

<section class="row g-4">
    <div class="col-md-4">
        <article class="stage-card h-100">
            <div class="stage-number">01</div>
            <h2 class="h5">CRUD оборудования</h2>
            <p class="mb-0 text-secondary">Добавление, поиск, редактирование и списание техники из активного реестра.</p>
        </article>
    </div>
    <div class="col-md-4">
        <article class="stage-card h-100">
            <div class="stage-number">02</div>
            <h2 class="h5">Заявки пользователей</h2>
            <p class="mb-0 text-secondary">Сводная таблица собирает данные через JOIN и показывает пользователя, оборудование и статус.</p>
        </article>
    </div>
    <div class="col-md-4">
        <article class="stage-card h-100">
            <div class="stage-number">03</div>
            <h2 class="h5">Стресс-тест данных</h2>
            <p class="mb-0 text-secondary">Сидер создаёт CSV-бэкап и массово генерирует записи для проверки пагинации и поиска.</p>
        </article>
    </div>
</section>
