<?php

namespace App\Services;

use App\Models\PropertyModel;
use App\Models\RoomModel;

/**
 * RoomService
 *
 * Layer service untuk logika bisnis kamar.
 */
class RoomService
{
    protected RoomModel $roomModel;
    protected PropertyModel $propertyModel;

    public function __construct()
    {
        $this->roomModel     = new RoomModel();
        $this->propertyModel = new PropertyModel();
    }

    /**
     * Ambil list kamar dalam satu properti dengan filtering dan paging.
     */
    public function getAllByProperty(int $propertyId, array $filters, int $page, int $perPage): array
    {
        $property = $this->propertyModel->find($propertyId);
        if (!$property) {
            return ['notFound' => true];
        }

        $model = $this->roomModel;

        if (!empty($filters['status'])) {
            $model->where('status', $filters['status']);
        }
        if (!empty($filters['type'])) {
            $model->where('type', $filters['type']);
        }

        $rooms = $model->where('property_id', $propertyId)->paginate($perPage, 'default', $page);
        $total = $model->pager->getTotal();
        $rooms = array_map([$this->roomModel, 'decodeJson'], $rooms);

        return compact('rooms', 'total');
    }

    /**
     * Ambil detail kamar beserta data propertinya.
     */
    public function getById(int $id): ?array
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            return null;
        }

        $room['property'] = $this->propertyModel->find($room['property_id']);
        return $this->roomModel->decodeJson($room);
    }

    /**
     * Buat kamar baru di dalam properti.
     */
    public function create(int $propertyId, array $data, string $userId): array
    {
        $property = $this->propertyModel->find($propertyId);
        if (!$property) {
            return ['notFound' => true];
        }

        if ((string) $property['owner_id'] !== $userId) {
            return ['forbidden' => true];
        }

        $data['property_id'] = $propertyId;
        $data['status']      = 'available';

        if (!$this->roomModel->validate($data)) {
            return ['errors' => $this->roomModel->errors()];
        }

        $id = $this->roomModel->insert($data);
        if (!$id) {
            return ['errors' => ['db' => 'Failed to create room']];
        }

        return ['room' => $this->roomModel->decodeJson($this->roomModel->find($id))];
    }

    /**
     * Update kamar Cek kepemilikan properti sebelum update.
     */
    public function update(int $id, array $data, string $userId): array
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            return ['notFound' => true];
        }

        $property = $this->propertyModel->find($room['property_id']);
        if ((string) $property['owner_id'] !== $userId) {
            return ['forbidden' => true];
        }

        if (!$this->roomModel->update($id, $data)) {
            return ['errors' => $this->roomModel->errors()];
        }

        return ['room' => $this->roomModel->decodeJson($this->roomModel->find($id))];
    }

    /**
     * Hapus kamar Cek kepemilikan properti sebelum hapus.
     */
    public function delete(int $id, string $userId): array
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            return ['notFound' => true];
        }

        $property = $this->propertyModel->find($room['property_id']);
        if ((string) $property['owner_id'] !== $userId) {
            return ['forbidden' => true];
        }

        $this->roomModel->delete($id);
        return ['deleted' => true];
    }
}
