<?php
declare(strict_types=1);

$result = $contentData['result'] ?? ['success' => false, 'message' => 'Неизвестная ошибка.'];
$equipment = $contentData['equipment'] ?? null;
?>
<section class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg">
            <div class="card-header <?= ($result['success'] ?? false) === true ? 'auth-header' : 'bg-danger text-white' ?>">
                <h1 class="h3 mb-0"><?= ($result['success'] ?? false) === true ? 'Заявка оформлена' : 'Операция не выполнена' ?></h1>
            </div>
            <div class="card-body p-4 p-lg-5">
                <p class="lead mb-4"><?= h((string) ($result['message'] ?? '')) ?></p>

                <?php if (($result['success'] ?? false) === true && is_array($equipment)): ?>
                    <div class="profile-field mb-4">
                        <span class="profile-label">Оборудование</span>
                        <strong><?= h((string) $equipment['title']) ?></strong>
                        <div class="text-secondary mt-2">Инвентарный номер: <?= h((string) $equipment['inventory_number']) ?></div>
                    </div>
                <?php endif; ?>

                <div class="d-flex flex-wrap gap-2">
                    <a href="index.php" class="btn btn-primary">Вернуться на главную</a>
                    <?php if ($authService->isAdmin()): ?>
                        <a href="admin_orders.php" class="btn btn-outline-secondary">Открыть заявки</a>
                    <?php else: ?>
                        <a href="profile.php" class="btn btn-outline-secondary">Открыть профиль</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
