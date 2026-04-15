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

CREATE TABLE IF NOT EXISTS `equipment_history` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `equipment_id` INT(11) DEFAULT NULL COMMENT 'ID оборудования, если запись ещё существует',
  `action` ENUM('create', 'update', 'delete') NOT NULL COMMENT 'Тип изменения',
  `inventory_number` VARCHAR(50) NOT NULL COMMENT 'Инвентарный номер на момент изменения',
  `title` VARCHAR(255) NOT NULL COMMENT 'Название на момент изменения',
  `change_reason` VARCHAR(255) DEFAULT NULL COMMENT 'Причина списания или комментарий',
  `snapshot_json` LONGTEXT DEFAULT NULL COMMENT 'Снимок данных в JSON',
  `changed_by_user_id` INT(11) DEFAULT NULL COMMENT 'Кто выполнил действие',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `equipment_history_equipment_idx` (`equipment_id`),
  KEY `equipment_history_user_idx` (`changed_by_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

