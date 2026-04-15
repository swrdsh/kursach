<?php
declare(strict_types=1);

namespace App\Repositories;

use DateInterval;
use DateTimeImmutable;
use PDO;

final class OrderRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function create(int $userId, int $equipmentId): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO orders (user_id, equipment_id) VALUES (:user_id, :equipment_id)'
        );
        $statement->execute([
            'user_id' => $userId,
            'equipment_id' => $equipmentId,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function hasRecentByUserAndEquipment(int $userId, int $equipmentId, int $minutes): bool
    {
        $threshold = (new DateTimeImmutable())->sub(new DateInterval('PT' . $minutes . 'M'));
        $statement = $this->pdo->prepare(
            'SELECT COUNT(*)
             FROM orders
             WHERE user_id = :user_id
               AND equipment_id = :equipment_id
               AND created_at >= :threshold'
        );
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':equipment_id', $equipmentId, PDO::PARAM_INT);
        $statement->bindValue(':threshold', $threshold->format('Y-m-d H:i:s'));
        $statement->execute();

        return (int) $statement->fetchColumn() > 0;
    }

    public function getAdminList(): array
    {
        $statement = $this->pdo->query(
            'SELECT
                orders.id AS order_id,
                orders.created_at,
                orders.status,
                users.email,
                users.username,
                equipment.title,
                equipment.inventory_number,
                equipment.purchase_cost
             FROM orders
             JOIN users ON orders.user_id = users.id
             JOIN equipment ON orders.equipment_id = equipment.id
             ORDER BY orders.id DESC'
        );

        return $statement->fetchAll();
    }
}
