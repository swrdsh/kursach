<?php
declare(strict_types=1);

$errorMessage = (string) ($contentData['errorMessage'] ?? '');
$successMessage = (string) ($contentData['successMessage'] ?? '');
$old = $contentData['old'] ?? [];
?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-lg">
            <div class="card-header auth-header">
                <h1 class="h3 mb-0">Регистрация</h1>
            </div>
            <div class="card-body p-4 p-lg-5">
                <?php if ($errorMessage !== ''): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($errorMessage, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
                <?php endif; ?>

                <?php if ($successMessage !== ''): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($successMessage, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?> <a href="login.php" class="alert-link">Войти</a></div>
                <?php else: ?>
                    <form method="POST" action="register.php" class="vstack gap-3">
                        <div>
                            <label for="email" class="form-label">Email адрес</label>
                            <input id="email" type="email" name="email" class="form-control" value="<?= htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" required>
                        </div>
                        <div>
                            <label for="username" class="form-label">Имя пользователя</label>
                            <input id="username" type="text" name="username" class="form-control" value="<?= htmlspecialchars((string) ($old['username'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" placeholder="Например, Иван Петров">
                        </div>
                        <div>
                            <label for="phone" class="form-label">Телефон</label>
                            <input id="phone" type="text" name="phone" class="form-control" value="<?= htmlspecialchars((string) ($old['phone'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" placeholder="+7 (900) 000-00-00">
                        </div>
                        <div>
                            <label for="password" class="form-label">Пароль</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                        </div>
                        <div>
                            <label for="password_confirm" class="form-label">Подтверждение пароля</label>
                            <input id="password_confirm" type="password" name="password_confirm" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">Зарегистрироваться</button>
                    </form>
                    <p class="text-center text-secondary mt-3 mb-0">
                        Уже есть аккаунт? <a href="login.php">Войти</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

