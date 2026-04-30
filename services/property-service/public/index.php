<?php

// Define the front controller path
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Define the root path (where .env file is located)
define('ROOTPATH', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);

// Change to the front controller directory
chdir(__DIR__);

require FCPATH . '../app/Config/Paths.php';

$paths = new Config\Paths();

require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
