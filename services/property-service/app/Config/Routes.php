<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Health check
$routes->get('health', static function () {
    return \Config\Services::response()
        ->setJSON(['status' => 'OK', 'service' => 'Property Service']);
});

// Property routes (semua protected via JwtFilter)
$routes->group('api/properties', ['filter' => 'jwt'], static function ($routes) {
    $routes->get('/',                          'PropertyController::index');
    $routes->post('/',                         'PropertyController::create');
    $routes->get('(:num)',                     'PropertyController::show/$1');
    $routes->put('(:num)',                     'PropertyController::update/$1');
    $routes->patch('(:num)',                   'PropertyController::update/$1');
    $routes->delete('(:num)',                  'PropertyController::delete/$1');

    // Room routes nested di bawah property
    $routes->get('(:num)/rooms',               'RoomController::index/$1');
    $routes->post('(:num)/rooms',              'RoomController::create/$1');
});

// Room routes standalone
$routes->group('api/rooms', ['filter' => 'jwt'], static function ($routes) {
    $routes->get('(:num)',                     'RoomController::show/$1');
    $routes->put('(:num)',                     'RoomController::update/$1');
    $routes->patch('(:num)',                   'RoomController::update/$1');
    $routes->delete('(:num)',                  'RoomController::delete/$1');
});
