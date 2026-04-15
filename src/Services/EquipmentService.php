<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\EquipmentRepository;

final class EquipmentService
{
    public function __construct(
        private readonly EquipmentRepository $equipmentRepository
    ) {
    }

    public function getLatest(): array
    {
        return $this->equipmentRepository->getLatest();
    }

    public function create(array $payload): array
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
            return ['success' => false, 'message' => 'Заполните инвентарный номер и название.'];
        }

        if ($this->equipmentRepository->existsByInventoryNumber($inventoryNumber)) {
            return ['success' => false, 'message' => 'Такой инвентарный номер уже существует.'];
        }

        if ($purchaseCost !== '' && !is_numeric($purchaseCost)) {
            return ['success' => false, 'message' => 'Стоимость должна быть числом.'];
        }

        if ($imageUrl !== '' && filter_var($imageUrl, FILTER_VALIDATE_URL) === false) {
            return ['success' => false, 'message' => 'Некорректный URL изображения.'];
        }

        $this->equipmentRepository->create([
            'inventory_number' => $inventoryNumber,
            'title' => $title,
            'description' => $description !== '' ? $description : null,
            'equipment_type' => $equipmentType !== '' ? $equipmentType : null,
            'room_name' => $roomName !== '' ? $roomName : null,
            'responsible_person' => $responsiblePerson !== '' ? $responsiblePerson : null,
            'purchase_cost' => $purchaseCost !== '' ? $purchaseCost : null,
            'image_url' => $imageUrl !== '' ? $imageUrl : null,
        ]);

        return ['success' => true, 'message' => 'Запись об оборудовании успешно добавлена.'];
    }
}

