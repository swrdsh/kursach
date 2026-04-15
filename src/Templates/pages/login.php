<?php
declare(strict_types=1);

$errorMessage = (string) ($contentData['errorMessage'] ?? '');
$old = $contentData['old'] ?? [];
?>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card border-0 shadow-lg">
            <div class="card-header auth-header">
                <h1 class="h3 mb-0">Вход в систему</h1>
            </div>
            <div class="card-body p-4 p-lg-5">
                <?php if ($errorMessage !== ''): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($errorMessage, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php" class="vstack gap-3">
                    <div>
                        <label for="email" class="form-label">Email адрес</label>
                        <input id="email" type="email" name="email" class="form-control" value="<?= htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" required>
                    </div>
                    <div>
                        <label for="password" class="form-label">Пароль</label>
                        <input id="password" type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Войти</button>
                </form>
                <p class="text-center text-secondary mt-3 mb-0">
                    Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
                </p>
            </div>
        </div>
    </div>
</div>

