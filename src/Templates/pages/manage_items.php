<?php
declare(strict_types=1);

$items = $contentData['items'] ?? [];
$page = (int) ($contentData['page'] ?? 1);
$totalPages = (int) ($contentData['totalPages'] ?? 1);
$totalRows = (int) ($contentData['totalRows'] ?? 0);
$search = (string) ($contentData['search'] ?? '');
$csrfToken = (string) ($contentData['csrfToken'] ?? '');
$flashMessage = (string) ($contentData['flashMessage'] ?? '');
$flashType = (string) ($contentData['flashType'] ?? 'info');
?>
<section class="admin-hero mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <span class="eyebrow eyebrow--dark">CRUD</span>
            <h1 class="display-6 fw-bold mt-3 mb-2">Управление оборудованием</h1>
            <p class="text-secondary mb-0">Редактирование, списание и поиск записей реестра с безопасным удалением через POST.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="add_item.php" class="btn btn-primary">Добавить запись</a>
            <a href="admin_panel.php" class="btn btn-outline-secondary">В админку</a>
        </div>
    </div>
</section>

<section class="card border-0 shadow-lg mb-4">
    <div class="card-body p-4">
        <form method="GET" action="manage_items.php" class="row g-3 align-items-end">
            <div class="col-lg-8">
                <label for="q" class="form-label">Поиск по оборудованию</label>
                <input id="q" type="text" name="q" class="form-control" value="<?= h($search) ?>" placeholder="Инвентарный номер, название, кабинет, МОЛ...">
            </div>
            <div class="col-lg-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Найти</button>
                <a href="manage_items.php" class="btn btn-outline-secondary">Сбросить</a>
            </div>
        </form>
    </div>
</section>

<?php if ($flashMessage !== ''): ?>
    <div class="alert alert-<?= h($flashType) ?>"><?= h($flashMessage) ?></div>
<?php endif; ?>

<section class="card border-0 shadow-lg">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Всего записей: <?= h((string) $totalRows) ?></h2>
            <span class="text-secondary">Страница <?= h((string) $page) ?> из <?= h((string) $totalPages) ?></span>
        </div>

        <?php if ($items === []): ?>
            <div class="empty-state">
                <h3 class="h4 mb-2">Записи не найдены</h3>
                <p class="text-secondary mb-0">Попробуйте изменить поисковый запрос или добавьте новое оборудование.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Инв. номер</th>
                            <th>Название</th>
                            <th>Кабинет</th>
                            <th>МОЛ</th>
                            <th>Стоимость</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= h((string) $item['id']) ?></td>
                                <td><?= h((string) $item['inventory_number']) ?></td>
                                <td>
                                    <div class="fw-semibold"><?= h((string) $item['title']) ?></div>
                                    <div class="small text-secondary"><?= h((string) ($item['equipment_type'] ?: 'Тип не указан')) ?></div>
                                </td>
                                <td><?= h((string) ($item['room_name'] ?: 'Не указан')) ?></td>
                                <td><?= h((string) ($item['responsible_person'] ?: 'Не назначено')) ?></td>
                                <td><?= h((string) ($item['purchase_cost'] !== null ? $item['purchase_cost'] . ' ₽' : 'Не указана')) ?></td>
                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        <a href="edit_item.php?id=<?= h((string) $item['id']) ?>" class="btn btn-warning btn-sm">Редактировать</a>
                                        <form action="delete_item.php" method="POST" onsubmit="return confirm('Вы уверены?');" class="vstack gap-2">
                                            <input type="hidden" name="id" value="<?= h((string) $item['id']) ?>">
                                            <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
                                            <input type="text" name="writeoff_reason" class="form-control form-control-sm" placeholder="Причина списания" required>
                                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
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
