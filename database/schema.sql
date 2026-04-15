SET NAMES utf8mb4;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный ID',
  `email` VARCHAR(255) NOT NULL COMMENT 'Логин пользователя',
  `password_hash` VARCHAR(255) NOT NULL COMMENT 'Хеш пароля (НЕ сам пароль!)',
  `username` VARCHAR(100) DEFAULT NULL COMMENT 'Имя для отображения',
  `phone` VARCHAR(20) DEFAULT NULL COMMENT 'Телефон для связи',
  `role` ENUM('admin', 'client') NOT NULL DEFAULT 'client' COMMENT 'Роль доступа',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата регистрации',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

