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

    public function getPaginated(int $limit, int $offset, ?string $search = null): array
    {
        [$whereSql, $params] = $this->buildSearchFilter($search);

        $statement = $this->pdo->prepare(
            'SELECT id, inventory_number, title, description, equipment_type, room_name, responsible_person, purchase_cost, image_url, created_at
             FROM equipment
             ' . $whereSql . '
             ORDER BY id DESC
             LIMIT :limit OFFSET :offset'
        );

        foreach ($params as $name => $value) {
            $statement->bindValue($name, $value);
        }

        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function countAll(?string $search = null): int
    {
        [$whereSql, $params] = $this->buildSearchFilter($search);

        $statement = $this->pdo->prepare('SELECT COUNT(*) FROM equipment ' . $whereSql);
        foreach ($params as $name => $value) {
            $statement->bindValue($name, $value);
        }
        $statement->execute();

        return (int) $statement->fetchColumn();
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

    public function existsByInventoryNumber(string $inventoryNumber, ?int $excludeId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM equipment WHERE inventory_number = :inventory_number';
        if ($excludeId !== null) {
            $sql .= ' AND id != :exclude_id';
        }

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':inventory_number', $inventoryNumber);
        if ($excludeId !== null) {
            $statement->bindValue(':exclude_id', $excludeId, PDO::PARAM_INT);
        }
        $statement->execute();

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

    public function update(int $id, array $itemData): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE equipment
             SET
                inventory_number = :inventory_number,
                title = :title,
                description = :description,
                equipment_type = :equipment_type,
                room_name = :room_name,
                responsible_person = :responsible_person,
                purchase_cost = :purchase_cost,
                image_url = :image_url
             WHERE id = :id'
        );

        $statement->execute([
            'id' => $id,
            'inventory_number' => $itemData['inventory_number'],
            'title' => $itemData['title'],
            'description' => $itemData['description'],
            'equipment_type' => $itemData['equipment_type'],
            'room_name' => $itemData['room_name'],
            'responsible_person' => $itemData['responsible_person'],
            'purchase_cost' => $itemData['purchase_cost'],
            'image_url' => $itemData['image_url'],
        ]);
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM equipment WHERE id = :id');
        $statement->execute([
            'id' => $id,
        ]);
    }

    public function getAllForExport(): array
    {
        $statement = $this->pdo->query('SELECT * FROM equipment ORDER BY id ASC');

        return $statement->fetchAll();
    }

    private function buildSearchFilter(?string $search): array
    {
        $search = trim((string) $search);
        if ($search === '') {
            return ['', []];
        }

        $like = '%' . $search . '%';

        return [
            'WHERE inventory_number LIKE :search_inventory
                OR title LIKE :search_title
                OR equipment_type LIKE :search_type
                OR room_name LIKE :search_room
                OR responsible_person LIKE :search_person',
            [
                ':search_inventory' => $like,
                ':search_title' => $like,
                ':search_type' => $like,
                ':search_room' => $like,
                ':search_person' => $like,
            ],
        ];
    }
}

