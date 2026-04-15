<?php
declare(strict_types=1);

$orders = $contentData['orders'] ?? [];
?>
<section class="admin-hero mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <span class="eyebrow eyebrow--dark">JOIN</span>
            <h1 class="display-6 fw-bold mt-3 mb-2">Управление заявками</h1>
            <p class="text-secondary mb-0">Сводный список показывает реальные данные пользователей и оборудования, а не только ID.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="admin_panel.php" class="btn btn-outline-secondary">В админку</a>
            <a href="index.php" class="btn btn-outline-primary">На главную</a>
        </div>
    </div>
</section>

<section class="card border-0 shadow-lg">
    <div class="card-body p-4">
        <?php if ($orders === []): ?>
            <div class="empty-state">
                <h2 class="h4 mb-2">Заявок пока нет</h2>
                <p class="text-secondary mb-0">Оформите 2-3 тестовые заявки, и здесь появится сводная таблица.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID заявки</th>
                            <th>Дата</th>
                            <th>Клиент</th>
                            <th>Оборудование</th>
                            <th>Инв. номер</th>
                            <th>Стоимость</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= h((string) $order['order_id']) ?></td>
                                <td><?= h((string) $order['created_at']) ?></td>
                                <td>
                                    <div class="fw-semibold"><?= h((string) $order['email']) ?></div>
                                    <div class="small text-secondary"><?= h((string) ($order['username'] ?: 'Без имени')) ?></div>
                                </td>
                                <td><?= h((string) $order['title']) ?></td>
                                <td><?= h((string) $order['inventory_number']) ?></td>
                                <td><?= h((string) ($order['purchase_cost'] !== null ? $order['purchase_cost'] . ' ₽' : 'Не указана')) ?></td>
                                <td><span class="status-chip status-chip--<?= h((string) $order['status']) ?>"><?= h((string) $order['status']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
