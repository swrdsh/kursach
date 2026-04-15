<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\EquipmentRepository;

final class SeederService
{
    public function __construct(
        private readonly EquipmentRepository $equipmentRepository,
        private readonly string $exportDirectory
    ) {
    }

    public function getAvailableTables(): array
    {
        return ['equipment'];
    }

    public function seedEquipment(int $count): array
    {
        $count = max(1, min(1000, $count));
        $rows = $this->equipmentRepository->getAllForExport();

        if ($rows === []) {
            return [
                'success' => false,
                'message' => 'Таблица equipment пуста. Сначала создайте хотя бы одну запись вручную.',
            ];
        }

        if (!is_dir($this->exportDirectory)) {
            mkdir($this->exportDirectory, 0775, true);
        }

        $filename = 'equipment_' . date('Y-m-d_H-i-s') . '.csv';
        $fullPath = rtrim($this->exportDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        $fp = fopen($fullPath, 'wb');

        if ($fp === false) {
            return [
                'success' => false,
                'message' => 'Не удалось создать CSV-бэкап.',
            ];
        }

        fputcsv($fp, array_keys($rows[0]));
        foreach ($rows as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);

        $inserted = 0;
        for ($i = 0; $i < $count; $i++) {
            $template = $rows[array_rand($rows)];
            $newInventory = (string) $template['inventory_number'] . '_S' . random_int(1000, 9999);
            $newTitle = (string) $template['title'] . ' #' . random_int(1000, 9999);
            $newCost = $template['purchase_cost'];

            if ($newCost !== null && $newCost !== '') {
                $percent = random_int(-15, 15) / 100;
                $newCost = round((float) $newCost * (1 + $percent), 2);
            }

            $result = $this->equipmentRepository->create([
                'inventory_number' => $newInventory,
                'title' => $newTitle,
                'description' => $template['description'],
                'equipment_type' => $template['equipment_type'],
                'room_name' => $template['room_name'],
                'responsible_person' => $template['responsible_person'],
                'purchase_cost' => $newCost,
                'image_url' => $template['image_url'],
            ]);

            if ($result > 0) {
                $inserted++;
            }
        }

        return [
            'success' => true,
            'message' => 'Бэкап создан и генерация завершена.',
            'backup_file' => 'exports/' . $filename,
            'inserted' => $inserted,
            'requested' => $count,
        ];
    }
}

