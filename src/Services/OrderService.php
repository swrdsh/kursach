<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\EquipmentRepository;
use App\Repositories\OrderRepository;

final class OrderService
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly EquipmentRepository $equipmentRepository
    ) {
    }

    public function placeOrder(int $userId, int $equipmentId): array
    {
        if ($equipmentId <= 0) {
            return ['success' => false, 'message' => 'Неверный идентификатор оборудования.'];
        }

        $equipment = $this->equipmentRepository->findById($equipmentId);

        if ($equipment === null) {
            return ['success' => false, 'message' => 'Ошибка: попытка оформить заявку на несуществующее оборудование.'];
        }

        if ($this->orderRepository->hasRecentByUserAndEquipment($userId, $equipmentId, 5)) {
            return ['success' => false, 'message' => 'Повторная заявка на это оборудование возможна не чаще одного раза в 5 минут.'];
        }

        $this->orderRepository->create($userId, $equipmentId);

        return [
            'success' => true,
            'message' => 'Заявка успешно оформлена. Ответственный сотрудник увидит её в панели заявок.',
            'equipment' => $equipment,
        ];
    }

    public function getAdminList(): array
    {
        return $this->orderRepository->getAdminList();
    }
}
