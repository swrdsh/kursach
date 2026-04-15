<?php
declare(strict_types=1);
?>
<section class="admin-hero mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <span class="hero-badge">RBAC</span>
            <h1 class="display-6 fw-bold mt-3 mb-2">Панель администратора</h1>
            <p class="text-secondary mb-0">Закрытая зона для управления карточками офисного оборудования.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="add_item.php" class="btn btn-primary">Добавить запись</a>
            <a href="admin_orders.php" class="btn btn-outline-primary">Заявки</a>
            <a href="index.php" class="btn btn-outline-secondary">На главную</a>
            <a href="logout.php" class="btn btn-outline-danger">Выйти</a>
        </div>
    </div>
</section>

<section class="row g-4">
    <div class="col-md-4">
        <article class="stage-card h-100">
            <div class="stage-number">01</div>
            <h2 class="h5">Права доступа</h2>
            <p class="mb-0 text-secondary">Страницы `admin_panel.php` и `add_item.php` доступны только пользователям с ролью `admin`.</p>
        </article>
    </div>
    <div class="col-md-4">
        <article class="stage-card h-100">
            <div class="stage-number">02</div>
            <h2 class="h5">Создание записей</h2>
            <p class="mb-0 text-secondary">Администратор добавляет оборудование с инвентарным номером, кабинетом, типом техники и стоимостью.</p>
        </article>
    </div>
    <div class="col-md-4">
        <article class="stage-card h-100">
            <div class="stage-number">03</div>
            <h2 class="h5">Заявки пользователей</h2>
            <p class="mb-0 text-secondary">Страница `admin_orders.php` собирает заявки через JOIN и показывает, кто и на какое оборудование оставил запрос.</p>
        </article>
    </div>
</section>
