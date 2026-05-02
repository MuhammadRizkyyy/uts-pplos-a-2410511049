<?php

namespace App\Controllers;

use App\Services\PropertyService;
use CodeIgniter\RESTful\ResourceController;

class PropertyController extends ResourceController
{
    protected $format = 'json';
    protected PropertyService $service;

    public function __construct()
    {
        $this->service = new PropertyService();
    }

    public function index()
    {
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        $filters = [
            'city'      => $this->request->getGet('city'),
            'type'      => $this->request->getGet('type'),
            'is_active' => $this->request->getGet('is_active'),
            'owner_id'  => $this->request->getGet('owner_id'),
        ];

        $result = $this->service->getAll($filters, $page, $perPage);

        return $this->respond([
            'data'     => $result['properties'],
            'total'    => $result['total'],
            'page'     => $page,
            'per_page' => $perPage,
        ]);
    }

    public function create()
    {
        $userId = $this->request->getHeaderLine('X-User-Id');
        $role   = $this->request->getHeaderLine('X-User-Role');

        if ($role !== 'owner') {
            return $this->failForbidden('Only owners can create properties');
        }

        $data   = $this->request->getJSON(true) ?? $this->request->getPost();
        $result = $this->service->create($data, $userId);

        if (isset($result['errors'])) {
            return $this->failValidationErrors($result['errors']);
        }

        return $this->respondCreated($result['property']);
    }

    public function show($id = null)
    {
        $property = $this->service->getById((int) $id);

        if (!$property) {
            return $this->failNotFound('Property not found');
        }

        return $this->respond($property);
    }

    public function update($id = null)
    {
        $userId = $this->request->getHeaderLine('X-User-Id');
        $role   = $this->request->getHeaderLine('X-User-Role');

        if ($role !== 'owner') {
            return $this->failForbidden('Only owners can update properties');
        }

        $data   = $this->request->getJSON(true) ?? $this->request->getRawInput();
        $result = $this->service->update((int) $id, $data, $userId);

        if (isset($result['notFound']))  return $this->failNotFound('Property not found');
        if (isset($result['forbidden'])) return $this->failForbidden('Forbidden');
        if (isset($result['errors']))    return $this->failValidationErrors($result['errors']);

        return $this->respond($result['property']);
    }

    public function delete($id = null)
    {
        $userId = $this->request->getHeaderLine('X-User-Id');
        $role   = $this->request->getHeaderLine('X-User-Role');

        if ($role !== 'owner') {
            return $this->failForbidden('Only owners can delete properties');
        }

        $result = $this->service->delete((int) $id, $userId);

        if (isset($result['notFound']))  return $this->failNotFound('Property not found');
        if (isset($result['forbidden'])) return $this->failForbidden('Forbidden');

        return $this->respondDeleted(['message' => 'Property deleted']);
    }
}
