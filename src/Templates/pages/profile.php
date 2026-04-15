<?php
declare(strict_types=1);

$user = $contentData['user'] ?? null;
?>
<section class="row justify-content-center">
    <div class="col-lg-8">
        <div class="profile-card shadow-lg border-0">
            <div class="profile-card__header">
                <div>
                    <span class="eyebrow eyebrow--dark">Защищённая страница</span>
                    <h1 class="h2 mt-3 mb-2">Профиль пользователя</h1>
                    <p class="text-secondary mb-0">Здесь отображаются данные текущего пользователя и роль доступа в системе.</p>
                </div>
                <span class="role-chip"><?= htmlspecialchars((string) ($user['role'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
            </div>

            <div class="profile-grid">
                <div class="profile-field">
                    <span class="profile-label">ID пользователя</span>
                    <strong><?= htmlspecialchars((string) ($user['id'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong>
                </div>
                <div class="profile-field">
                    <span class="profile-label">Email</span>
                    <strong><?= htmlspecialchars((string) ($user['email'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong>
                </div>
                <div class="profile-field">
                    <span class="profile-label">Имя</span>
                    <strong><?= htmlspecialchars((string) (($user['username'] ?? '') !== '' ? $user['username'] : 'Не указано'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong>
                </div>
                <div class="profile-field">
                    <span class="profile-label">Телефон</span>
                    <strong><?= htmlspecialchars((string) (($user['phone'] ?? '') !== '' ? $user['phone'] : 'Не указан'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong>
                </div>
                <div class="profile-field">
                    <span class="profile-label">Роль</span>
                    <strong><?= htmlspecialchars((string) ($user['role'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong>
                </div>
                <div class="profile-field">
                    <span class="profile-label">Дата регистрации</span>
                    <strong><?= htmlspecialchars((string) ($user['created_at'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong>
                </div>
            </div>
        </div>
    </div>
</section>
