SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `equipment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `inventory_number` VARCHAR(50) NOT NULL COMMENT 'Инвентарный номер',
  `title` VARCHAR(255) NOT NULL COMMENT 'Название оборудования',
  `description` TEXT DEFAULT NULL COMMENT 'Описание или примечание',
  `equipment_type` VARCHAR(100) DEFAULT NULL COMMENT 'Тип техники',
  `room_name` VARCHAR(100) DEFAULT NULL COMMENT 'Кабинет',
  `responsible_person` VARCHAR(150) DEFAULT NULL COMMENT 'Материально-ответственное лицо',
  `purchase_cost` DECIMAL(10, 2) DEFAULT NULL COMMENT 'Стоимость',
  `image_url` VARCHAR(255) DEFAULT NULL COMMENT 'Ссылка на изображение',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventory_number_unique` (`inventory_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

