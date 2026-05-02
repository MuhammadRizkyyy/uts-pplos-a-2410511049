<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table            = 'rooms';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'property_id', 'room_number', 'type',
        'price_per_month', 'size_sqm', 'facilities', 'status', 'description',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'room_number'     => 'required|max_length[20]',
        'type'            => 'required|max_length[50]',
        'price_per_month' => 'required|decimal|greater_than[0]',
    ];

    protected $beforeInsert = ['encodeJson'];
    protected $beforeUpdate = ['encodeJson'];

    protected function encodeJson(array $data): array
    {
        if (isset($data['data']['facilities']) && is_array($data['data']['facilities'])) {
            $data['data']['facilities'] = json_encode($data['data']['facilities']);
        }
        return $data;
    }

    public function decodeJson(array $row): array
    {
        if (isset($row['facilities']) && is_string($row['facilities'])) {
            $row['facilities'] = json_decode($row['facilities'], true);
        }
        return $row;
    }
}
