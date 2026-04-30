<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $table            = 'properties';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'owner_id', 'name', 'description', 'address',
        'city', 'province', 'type', 'facilities', 'rules', 'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'     => 'required|max_length[150]',
        'address'  => 'required',
        'city'     => 'required|max_length[100]',
        'province' => 'required|max_length[100]',
        'type'     => 'required|in_list[kos,kontrakan,apartemen]',
    ];

    protected $validationMessages = [
        'type' => ['in_list' => 'Type must be kos, kontrakan, or apartemen'],
    ];

    protected $beforeInsert = ['encodeJson'];
    protected $beforeUpdate = ['encodeJson'];

    protected function encodeJson(array $data): array
    {
        foreach (['facilities', 'rules'] as $field) {
            if (isset($data['data'][$field]) && is_array($data['data'][$field])) {
                $data['data'][$field] = json_encode($data['data'][$field]);
            }
        }
        return $data;
    }

    public function decodeJson(array $row): array
    {
        foreach (['facilities', 'rules'] as $field) {
            if (isset($row[$field]) && is_string($row[$field])) {
                $row[$field] = json_decode($row[$field], true);
            }
        }
        return $row;
    }
}
