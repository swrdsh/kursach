<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use App\Support\SessionManager;

final class AuthService
{
    private const USER_SESSION_KEY = 'auth_user_id';
    private const ROLE_SESSION_KEY = 'auth_user_role';

    private ?array $currentUser = null;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly SessionManager $sessionManager
    ) {
    }

    public function register(array $payload): array
    {
        $email = trim((string) ($payload['email'] ?? ''));
        $password = (string) ($payload['password'] ?? '');
        $passwordConfirm = (string) ($payload['password_confirm'] ?? '');
        $username = trim((string) ($payload['username'] ?? ''));
        $phone = trim((string) ($payload['phone'] ?? ''));

        if ($email === '' || $password === '' || $passwordConfirm === '') {
            return ['success' => false, 'message' => 'Заполните все обязательные поля.'];
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return ['success' => false, 'message' => 'Некорректный формат email.'];
        }

        if ($password !== $passwordConfirm) {
            return ['success' => false, 'message' => 'Пароли не совпадают.'];
        }

        if (mb_strlen($password) < 6) {
            return ['success' => false, 'message' => 'Пароль должен содержать минимум 6 символов.'];
        }

        if ($this->userRepository->existsByEmail($email)) {
            return ['success' => false, 'message' => 'Такой email уже зарегистрирован.'];
        }

        $this->userRepository->create([
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'username' => $username !== '' ? $username : null,
            'phone' => $phone !== '' ? $phone : null,
            'role' => 'client',
        ]);

        return ['success' => true, 'message' => 'Регистрация успешна. Теперь можно войти в систему.'];
    }

    public function login(array $payload): array
    {
        $email = trim((string) ($payload['email'] ?? ''));
        $password = (string) ($payload['password'] ?? '');

        if ($email === '' || $password === '') {
            return ['success' => false, 'message' => 'Введите email и пароль.'];
        }

        $user = $this->userRepository->findByEmail($email);

        if ($user === null || !password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Неверный логин или пароль.'];
        }

        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $this->userRepository->updatePasswordHash(
                (int) $user['id'],
                password_hash($password, PASSWORD_DEFAULT)
            );
        }

        $this->sessionManager->regenerate();
        $this->sessionManager->set(self::USER_SESSION_KEY, (int) $user['id']);
        $this->sessionManager->set(self::ROLE_SESSION_KEY, $user['role']);
        $this->currentUser = $this->userRepository->findById((int) $user['id']);

        return ['success' => true, 'message' => 'Вход выполнен успешно.'];
    }

    public function logout(): void
    {
        $this->currentUser = null;
        $this->sessionManager->remove(self::USER_SESSION_KEY);
        $this->sessionManager->remove(self::ROLE_SESSION_KEY);
        $this->sessionManager->destroy();
    }

    public function isAuthenticated(): bool
    {
        return $this->sessionManager->has(self::USER_SESSION_KEY);
    }

    public function getCurrentUser(): ?array
    {
        if (!$this->isAuthenticated()) {
            return null;
        }

        if ($this->currentUser !== null) {
            return $this->currentUser;
        }

        $userId = (int) $this->sessionManager->get(self::USER_SESSION_KEY);
        $this->currentUser = $this->userRepository->findById($userId);

        return $this->currentUser;
    }

    public function getCurrentRole(): ?string
    {
        return $this->sessionManager->get(self::ROLE_SESSION_KEY);
    }

    public function isAdmin(): bool
    {
        return $this->isAuthenticated() && $this->getCurrentRole() === 'admin';
    }
}
