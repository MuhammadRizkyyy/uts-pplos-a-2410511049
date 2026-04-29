<?php

namespace App\Controllers;

use App\Services\RoomService;
use CodeIgniter\RESTful\ResourceController;

/**
 * RoomController
 *
 * Hanya bertanggung jawab atas HTTP request/response.
 * Semua logika bisnis didelegasikan ke RoomService.
 */
class RoomController extends ResourceController
{
    protected $format = 'json';
    protected RoomService $service;

    public function __construct()
    {
        $this->service = new RoomService();
    }

    /**
     * GET /api/properties/:propertyId/rooms
     */
    public function index($propertyId = null)
    {
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        $filters = [
            'status' => $this->request->getGet('status'),
            'type'   => $this->request->getGet('type'),
        ];

        $result = $this->service->getAllByProperty((int) $propertyId, $filters, $page, $perPage);

        if (isset($result['notFound'])) {
            return $this->failNotFound('Property not found');
        }

        return $this->respond([
            'data'     => $result['rooms'],
            'total'    => $result['total'],
            'page'     => $page,
            'per_page' => $perPage,
        ]);
    }

    /**
     * POST /api/properties/:propertyId/rooms
     */
    public function create($propertyId = null)
    {
        $userId = $this->request->getHeaderLine('X-User-Id');
        $data   = $this->request->getJSON(true) ?? $this->request->getPost();
        $result = $this->service->create((int) $propertyId, $data, $userId);

        if (isset($result['notFound']))  return $this->failNotFound('Property not found');
        if (isset($result['forbidden'])) return $this->failForbidden('Forbidden');
        if (isset($result['errors']))    return $this->failValidationErrors($result['errors']);

        return $this->respondCreated($result['room']);
    }

    /**
     * GET /api/rooms/:id
     */
    public function show($id = null)
    {
        $room = $this->service->getById((int) $id);

        if (!$room) {
            return $this->failNotFound('Room not found');
        }

        return $this->respond($room);
    }

    /**
     * PUT/PATCH /api/rooms/:id
     */
    public function update($id = null)
    {
        $userId = $this->request->getHeaderLine('X-User-Id');
        $data   = $this->request->getJSON(true) ?? $this->request->getRawInput();
        $result = $this->service->update((int) $id, $data, $userId);

        if (isset($result['notFound']))  return $this->failNotFound('Room not found');
        if (isset($result['forbidden'])) return $this->failForbidden('Forbidden');
        if (isset($result['errors']))    return $this->failValidationErrors($result['errors']);

        return $this->respond($result['room']);
    }

    /**
     * DELETE /api/rooms/:id
     */
    public function delete($id = null)
    {
        $userId = $this->request->getHeaderLine('X-User-Id');
        $result = $this->service->delete((int) $id, $userId);

        if (isset($result['notFound']))  return $this->failNotFound('Room not found');
        if (isset($result['forbidden'])) return $this->failForbidden('Forbidden');

        return $this->respondDeleted(['message' => 'Room deleted']);
    }
}
