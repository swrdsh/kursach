<?php
declare(strict_types=1);

$tables = $contentData['tables'] ?? [];
$messageText = (string) ($contentData['messageText'] ?? '');
$messageType = (string) ($contentData['messageType'] ?? 'info');
$csrfToken = (string) ($contentData['csrfToken'] ?? '');
?>
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card shadow-lg border-0">
            <div class="card-header auth-header">
                <h1 class="h3 mb-1">Генератор контента</h1>
                <p class="mb-0 opacity-75">Создание CSV-бэкапа и массовое клонирование записей для проверки пагинации и поиска.</p>
            </div>
            <div class="card-body p-4 p-lg-5">
                <?php if ($messageText !== ''): ?>
                    <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?>"><?= h($messageText) ?></div>
                <?php endif; ?>

                <form method="POST" action="admin_seeder.php" class="vstack gap-3">
                    <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
                    <div>
                        <label for="table_name" class="form-label">Выберите таблицу для наполнения</label>
                        <select id="table_name" name="table_name" class="form-select">
                            <?php foreach ($tables as $table): ?>
                                <option value="<?= h((string) $table) ?>"><?= h((string) $table) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Рекомендуется таблица equipment, чтобы проверить пагинацию и поиск.</div>
                    </div>
                    <div>
                        <label for="count" class="form-label">Сколько записей добавить?</label>
                        <input id="count" type="number" name="count" class="form-control" value="10" min="1" max="1000">
                    </div>
                    <div class="alert alert-warning mb-0">
                        Скрипт сначала сохранит CSV-бэкап в папку <code>/exports</code>, затем склонирует случайные записи
                        с изменением стоимости и уникальных идентификаторов.
                    </div>
                    <button type="submit" class="btn btn-success w-100">Запустить генерацию</button>
                </form>

                <div class="d-flex flex-wrap gap-2 mt-3">
                    <a href="manage_items.php" class="btn btn-outline-secondary">К управлению оборудованием</a>
                    <a href="index.php" class="btn btn-outline-primary">На сайт</a>
                </div>
            </div>
        </div>
    </div>
</div>
