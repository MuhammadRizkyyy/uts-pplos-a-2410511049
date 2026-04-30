<?php

namespace App\Services;

use App\Models\PropertyModel;
use App\Models\RoomModel;

class PropertyService
{
    protected PropertyModel $propertyModel;
    protected RoomModel $roomModel;

    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
        $this->roomModel     = new RoomModel();
    }

    public function getAll(array $filters, int $page, int $perPage): array
    {
        $model = $this->propertyModel;

        if (!empty($filters['city']))     $model->like('city', $filters['city']);
        if (!empty($filters['type']))     $model->where('type', $filters['type']);
        if (isset($filters['is_active'])) $model->where('is_active', $filters['is_active']);
        if (!empty($filters['owner_id'])) $model->where('owner_id', $filters['owner_id']);

        $properties = $model->paginate($perPage, 'default', $page);
        $total      = $model->pager->getTotal();
        $properties = array_map([$this->propertyModel, 'decodeJson'], $properties);

        return compact('properties', 'total');
    }

    public function getById(int $id): ?array
    {
        $property = $this->propertyModel->find($id);
        if (!$property) return null;

        $rooms             = $this->roomModel->where('property_id', $id)->findAll();
        $rooms             = array_map([$this->roomModel, 'decodeJson'], $rooms);
        $property['rooms'] = $rooms;

        return $this->propertyModel->decodeJson($property);
    }

    public function create(array $data, string $ownerId): array
    {
        $data['owner_id']  = $ownerId;
        $data['is_active'] = 1;

        if (!$this->propertyModel->validate($data)) {
            return ['errors' => $this->propertyModel->errors()];
        }

        $id = $this->propertyModel->insert($data);
        if (!$id) return ['errors' => ['db' => 'Failed to create property']];

        return ['property' => $this->propertyModel->decodeJson($this->propertyModel->find($id))];
    }

    public function update(int $id, array $data, string $userId): array
    {
        $property = $this->propertyModel->find($id);
        if (!$property) return ['notFound' => true];

        if ((string) $property['owner_id'] !== $userId) return ['forbidden' => true];

        if (!$this->propertyModel->update($id, $data)) {
            return ['errors' => $this->propertyModel->errors()];
        }

        return ['property' => $this->propertyModel->decodeJson($this->propertyModel->find($id))];
    }

    public function delete(int $id, string $userId): array
    {
        $property = $this->propertyModel->find($id);
        if (!$property) return ['notFound' => true];

        if ((string) $property['owner_id'] !== $userId) return ['forbidden' => true];

        $this->propertyModel->delete($id);
        return ['deleted' => true];
    }
}
