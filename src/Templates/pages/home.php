<?php
declare(strict_types=1);

$user = $authService->getCurrentUser();
?>
<section class="hero-card mb-4">
    <div class="row g-4 align-items-center">
        <div class="col-lg-7">
            <span class="hero-badge">Курсовой проект</span>
            <h1 class="display-5 fw-bold mt-3 mb-3">Инвентаризация офисного оборудования</h1>
            <p class="lead text-secondary mb-4">
                Первый этап реализует подсистему аутентификации: регистрацию, безопасное хранение паролей,
                вход через сессию и защищенный профиль пользователя.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <?php if ($user === null): ?>
                    <a class="btn btn-primary btn-lg" href="register.php">Создать аккаунт</a>
                    <a class="btn btn-outline-secondary btn-lg" href="login.php">Войти</a>
                <?php else: ?>
                    <a class="btn btn-primary btn-lg" href="profile.php">Открыть профиль</a>
                    <a class="btn btn-outline-secondary btn-lg" href="logout.php">Выйти</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="info-panel">
                <h2 class="h4 mb-3">Что уже готово</h2>
                <ul class="feature-list mb-0">
                    <li>PDO-подключение к MySQL через `db.php`</li>
                    <li>Таблица `users` с ролями `admin` и `client`</li>
                    <li>Хеширование пароля через `password_hash()`</li>
                    <li>Авторизация через `password_verify()` и сессии</li>
                    <li>Меню, зависящее от состояния пользователя</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="row g-4">
    <div class="col-md-4">
        <article class="stage-card h-100">
            <div class="stage-number">01</div>
            <h3 class="h5">Регистрация</h3>
            <p class="mb-0 text-secondary">Проверка email, совпадения паролей и защита от дублей по уникальному полю.</p>
        </article>
    </div>
    <div class="col-md-4">
        <article class="stage-card h-100">
            <div class="stage-number">02</div>
            <h3 class="h5">Авторизация</h3>
            <p class="mb-0 text-secondary">Вход по email и паролю с хранением идентификатора пользователя в сессии.</p>
        </article>
    </div>
    <div class="col-md-4">
        <article class="stage-card h-100">
            <div class="stage-number">03</div>
            <h3 class="h5">Защищенный профиль</h3>
            <p class="mb-0 text-secondary">Доступ к странице профиля есть только после успешной аутентификации.</p>
        </article>
    </div>
</section>

