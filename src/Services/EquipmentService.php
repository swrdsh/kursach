<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\EquipmentHistoryRepository;
use App\Repositories\EquipmentRepository;

final class EquipmentService
{
    public function __construct(
        private readonly EquipmentRepository $equipmentRepository,
        private readonly EquipmentHistoryRepository $equipmentHistoryRepository
    ) {
    }

    public function getCatalogPage(int $page, int $limit, ?string $search = null): array
    {
        $page = max(1, $page);
        $totalRows = $this->equipmentRepository->countAll($search);
        $totalPages = max(1, (int) ceil($totalRows / $limit));

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $limit;

        return [
            'items' => $this->equipmentRepository->getPaginated($limit, $offset, $search),
            'page' => $page,
            'limit' => $limit,
            'total_rows' => $totalRows,
            'total_pages' => $totalPages,
            'search' => trim((string) $search),
        ];
    }

    public function create(array $payload, ?int $changedByUserId = null): array
    {
        $normalized = $this->normalizePayload($payload);

        if ($normalized['error'] !== null) {
            return ['success' => false, 'message' => $normalized['error']];
        }

        if ($this->equipmentRepository->existsByInventoryNumber($normalized['data']['inventory_number'])) {
            return ['success' => false, 'message' => 'Такой инвентарный номер уже существует.'];
        }

        $id = $this->equipmentRepository->create($normalized['data']);
        $createdItem = $this->equipmentRepository->findById($id);

        if ($createdItem !== null) {
            $this->equipmentHistoryRepository->log(
                $id,
                'create',
                (string) $createdItem['inventory_number'],
                (string) $createdItem['title'],
                null,
                ['after' => $createdItem],
                $changedByUserId
            );
        }

        return ['success' => true, 'message' => 'Запись об оборудовании успешно добавлена.'];
    }

    public function findById(int $id): ?array
    {
        return $this->equipmentRepository->findById($id);
    }

    public function update(int $id, array $payload, ?int $changedByUserId = null): array
    {
        $currentItem = $this->equipmentRepository->findById($id);

        if ($currentItem === null) {
            return ['success' => false, 'message' => 'Оборудование не найдено.'];
        }

        $normalized = $this->normalizePayload($payload);

        if ($normalized['error'] !== null) {
            return ['success' => false, 'message' => $normalized['error']];
        }

        if ($this->equipmentRepository->existsByInventoryNumber($normalized['data']['inventory_number'], $id)) {
            return ['success' => false, 'message' => 'Такой инвентарный номер уже существует.'];
        }

        $this->equipmentRepository->update($id, $normalized['data']);
        $updatedItem = $this->equipmentRepository->findById($id);

        if ($updatedItem !== null) {
            $this->equipmentHistoryRepository->log(
                $id,
                'update',
                (string) $updatedItem['inventory_number'],
                (string) $updatedItem['title'],
                null,
                ['before' => $currentItem, 'after' => $updatedItem],
                $changedByUserId
            );
        }

        return ['success' => true, 'message' => 'Изменения сохранены.'];
    }

    public function delete(int $id, string $reason, ?int $changedByUserId = null): array
    {
        $currentItem = $this->equipmentRepository->findById($id);

        if ($currentItem === null) {
            return ['success' => false, 'message' => 'Оборудование не найдено.'];
        }

        $reason = trim($reason);
        if ($reason === '') {
            return ['success' => false, 'message' => 'Укажите причину списания оборудования.'];
        }

        $this->equipmentHistoryRepository->log(
            $id,
            'delete',
            (string) $currentItem['inventory_number'],
            (string) $currentItem['title'],
            $reason,
            ['before' => $currentItem],
            $changedByUserId
        );

        $this->equipmentRepository->delete($id);

        return ['success' => true, 'message' => 'Оборудование списано и удалено из активного реестра.'];
    }

    private function normalizePayload(array $payload): array
    {
        $inventoryNumber = trim((string) ($payload['inventory_number'] ?? ''));
        $title = trim((string) ($payload['title'] ?? ''));
        $description = trim((string) ($payload['description'] ?? ''));
        $equipmentType = trim((string) ($payload['equipment_type'] ?? ''));
        $roomName = trim((string) ($payload['room_name'] ?? ''));
        $responsiblePerson = trim((string) ($payload['responsible_person'] ?? ''));
        $purchaseCost = trim((string) ($payload['purchase_cost'] ?? ''));
        $imageUrl = trim((string) ($payload['image_url'] ?? ''));

        if ($inventoryNumber === '' || $title === '') {
            return ['error' => 'Заполните инвентарный номер и название.', 'data' => null];
        }

        if ($purchaseCost !== '' && !is_numeric($purchaseCost)) {
            return ['error' => 'Стоимость должна быть числом.', 'data' => null];
        }

        if ($imageUrl !== '' && filter_var($imageUrl, FILTER_VALIDATE_URL) === false) {
            return ['error' => 'Некорректный URL изображения.', 'data' => null];
        }

        return [
            'error' => null,
            'data' => [
                'inventory_number' => $inventoryNumber,
                'title' => $title,
                'description' => $description !== '' ? $description : null,
                'equipment_type' => $equipmentType !== '' ? $equipmentType : null,
                'room_name' => $roomName !== '' ? $roomName : null,
                'responsible_person' => $responsiblePerson !== '' ? $responsiblePerson : null,
                'purchase_cost' => $purchaseCost !== '' ? $purchaseCost : null,
                'image_url' => $imageUrl !== '' ? $imageUrl : null,
            ],
        ];
    }
}

