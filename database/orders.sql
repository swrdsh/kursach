SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL COMMENT 'Кто оформил заявку',
  `equipment_id` INT NOT NULL COMMENT 'На какое оборудование оформлена заявка',
  `status` ENUM('new', 'processing', 'done') NOT NULL DEFAULT 'new',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orders_user_idx` (`user_id`),
  KEY `orders_equipment_idx` (`equipment_id`),
  CONSTRAINT `orders_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_equipment_fk` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

