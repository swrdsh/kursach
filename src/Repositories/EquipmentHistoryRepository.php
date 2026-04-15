<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class EquipmentHistoryRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function log(
        ?int $equipmentId,
        string $action,
        string $inventoryNumber,
        string $title,
        ?string $changeReason,
        array $snapshot,
        ?int $changedByUserId
    ): void {
        $statement = $this->pdo->prepare(
            'INSERT INTO equipment_history (
                equipment_id,
                action,
                inventory_number,
                title,
                change_reason,
                snapshot_json,
                changed_by_user_id
             ) VALUES (
                :equipment_id,
                :action,
                :inventory_number,
                :title,
                :change_reason,
                :snapshot_json,
                :changed_by_user_id
             )'
        );

        $statement->execute([
            'equipment_id' => $equipmentId,
            'action' => $action,
            'inventory_number' => $inventoryNumber,
            'title' => $title,
            'change_reason' => $changeReason,
            'snapshot_json' => json_encode($snapshot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'changed_by_user_id' => $changedByUserId,
        ]);
    }
}
