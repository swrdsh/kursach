<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class EquipmentRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function getLatest(): array
    {
        $statement = $this->pdo->query(
            'SELECT id, inventory_number, title, description, equipment_type, room_name, responsible_person, purchase_cost, image_url, created_at
             FROM equipment
             ORDER BY id DESC'
        );

        return $statement->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT id, inventory_number, title, description, equipment_type, room_name, responsible_person, purchase_cost, image_url, created_at
             FROM equipment
             WHERE id = :id
             LIMIT 1'
        );
        $statement->execute([
            'id' => $id,
        ]);
        $item = $statement->fetch();

        return $item === false ? null : $item;
    }

    public function existsByInventoryNumber(string $inventoryNumber): bool
    {
        $statement = $this->pdo->prepare(
            'SELECT COUNT(*) FROM equipment WHERE inventory_number = :inventory_number'
        );
        $statement->execute([
            'inventory_number' => $inventoryNumber,
        ]);

        return (int) $statement->fetchColumn() > 0;
    }

    public function create(array $itemData): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO equipment (
                inventory_number,
                title,
                description,
                equipment_type,
                room_name,
                responsible_person,
                purchase_cost,
                image_url
             ) VALUES (
                :inventory_number,
                :title,
                :description,
                :equipment_type,
                :room_name,
                :responsible_person,
                :purchase_cost,
                :image_url
             )'
        );

        $statement->execute([
            'inventory_number' => $itemData['inventory_number'],
            'title' => $itemData['title'],
            'description' => $itemData['description'],
            'equipment_type' => $itemData['equipment_type'],
            'room_name' => $itemData['room_name'],
            'responsible_person' => $itemData['responsible_person'],
            'purchase_cost' => $itemData['purchase_cost'],
            'image_url' => $itemData['image_url'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }
}
