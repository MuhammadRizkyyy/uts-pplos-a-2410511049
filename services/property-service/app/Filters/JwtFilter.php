<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * JWT Filter
 *
 * Gateway sudah memvalidasi JWT dan meneruskan header X-User-Id & X-User-Role.
 * Filter ini hanya memastikan header tersebut ada sebelum request masuk ke controller.
 */
class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userId = $request->getHeaderLine('X-User-Id');

        if (empty($userId)) {
            return \Config\Services::response()
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                ->setJSON(['error' => 'Unauthorized']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // placeholder
    }
}
