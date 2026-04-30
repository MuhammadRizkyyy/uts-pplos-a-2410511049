<?php

namespace Config;

class Paths
{
    public string $systemDirectory;
    public string $appDirectory;
    public string $writableDirectory;
    public string $testsDirectory;
    public string $viewDirectory;

    public function __construct()
    {
        $root = realpath(__DIR__ . '/../../');

        $this->systemDirectory   = $root . '/vendor/codeigniter4/framework/system';
        $this->appDirectory      = $root . '/app';
        $this->writableDirectory = $root . '/writable';
        $this->testsDirectory    = $root . '/tests';
        $this->viewDirectory     = $root . '/app/Views';
    }
}
