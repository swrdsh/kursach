<?php
declare(strict_types=1);

$heading = (string) ($contentData['heading'] ?? 'Форма оборудования');
$descriptionText = (string) ($contentData['descriptionText'] ?? '');
$formAction = (string) ($contentData['formAction'] ?? 'add_item.php');
$submitLabel = (string) ($contentData['submitLabel'] ?? 'Сохранить');
$backLink = (string) ($contentData['backLink'] ?? 'admin_panel.php');
$messageType = (string) ($contentData['messageType'] ?? '');
$messageText = (string) ($contentData['messageText'] ?? '');
$old = $contentData['old'] ?? [];
$csrfToken = (string) ($contentData['csrfToken'] ?? '');
?>
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card border-0 shadow-lg">
            <div class="card-header auth-header">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h1 class="h3 mb-1"><?= h($heading) ?></h1>
                        <p class="mb-0 opacity-75"><?= h($descriptionText) ?></p>
                    </div>
                    <a href="<?= h($backLink) ?>" class="btn btn-light">← Назад</a>
                </div>
            </div>
            <div class="card-body p-4 p-lg-5">
                <?php if ($messageText !== ''): ?>
                    <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?>">
                        <?= h($messageText) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= h($formAction) ?>" class="row g-3">
                    <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
                    <div class="col-md-6">
                        <label for="inventory_number" class="form-label">Инвентарный номер</label>
                        <input id="inventory_number" type="text" name="inventory_number" class="form-control" value="<?= h((string) ($old['inventory_number'] ?? '')) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="title" class="form-label">Название оборудования</label>
                        <input id="title" type="text" name="title" class="form-control" value="<?= h((string) ($old['title'] ?? '')) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="equipment_type" class="form-label">Тип техники</label>
                        <input id="equipment_type" type="text" name="equipment_type" class="form-control" value="<?= h((string) ($old['equipment_type'] ?? '')) ?>" placeholder="Ноутбук, принтер, МФУ...">
                    </div>
                    <div class="col-md-6">
                        <label for="room_name" class="form-label">Кабинет</label>
                        <input id="room_name" type="text" name="room_name" class="form-control" value="<?= h((string) ($old['room_name'] ?? '')) ?>" placeholder="Кабинет 203">
                    </div>
                    <div class="col-md-6">
                        <label for="responsible_person" class="form-label">Материально-ответственное лицо</label>
                        <input id="responsible_person" type="text" name="responsible_person" class="form-control" value="<?= h((string) ($old['responsible_person'] ?? '')) ?>" placeholder="Иванов И.И.">
                    </div>
                    <div class="col-md-6">
                        <label for="purchase_cost" class="form-label">Стоимость</label>
                        <input id="purchase_cost" type="number" name="purchase_cost" class="form-control" value="<?= h((string) ($old['purchase_cost'] ?? '')) ?>" placeholder="59990" step="0.01" min="0">
                    </div>
                    <div class="col-12">
                        <label for="image_url" class="form-label">URL изображения</label>
                        <input id="image_url" type="url" name="image_url" class="form-control" value="<?= h((string) ($old['image_url'] ?? '')) ?>" placeholder="https://example.com/device.jpg">
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">Описание</label>
                        <textarea id="description" name="description" class="form-control form-control--area" placeholder="Краткое описание состояния, комплектации или назначения"><?= h((string) ($old['description'] ?? '')) ?></textarea>
                    </div>
                    <div class="col-12 d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-success px-4"><?= h($submitLabel) ?></button>
                        <a href="manage_items.php" class="btn btn-outline-secondary">Управление оборудованием</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

