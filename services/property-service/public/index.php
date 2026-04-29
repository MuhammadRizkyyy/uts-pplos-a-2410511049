<?php

/**
 * CodeIgniter 4 - Front Controller
 */

// Path ke folder system CI4 (setelah composer install)
$pathsConfig = FCPATH . '../vendor/codeigniter4/framework/system';

// Pastikan path system ada
if (! is_dir($pathsConfig)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'The framework system directory does not exist: ' . $pathsConfig;
    exit(3);
}

define('SYSTEMPATH', rtrim($pathsConfig, '/\\') . DIRECTORY_SEPARATOR);
define('APPPATH', realpath(rtrim(__DIR__ . '/../app', '/\\')) . DIRECTORY_SEPARATOR);
define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
define('WRITEPATH', ROOTPATH . 'writable' . DIRECTORY_SEPARATOR);
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

require SYSTEMPATH . 'bootstrap.php';

$app = \Config\Services::codeigniter();
$app->initialize();
$context = \CodeIgniter\Boot::bootWeb($app);
