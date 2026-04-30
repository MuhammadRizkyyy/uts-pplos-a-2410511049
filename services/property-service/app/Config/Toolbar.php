<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * --------------------------------------------------------------------------
 * Debug Toolbar
 * --------------------------------------------------------------------------
 *
 * The Debug Toolbar provides a way to see information about the performance
 * and state of your application during that page display. By default it will
 * NOT be displayed under production environments, and will only display if
 * CI_DEBUG is true, since if it's not, there's not much to display anyway.
 */
class Toolbar extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Toolbar Views Path
     * --------------------------------------------------------------------------
     *
     * The full path to the the views that are used by the toolbar.
     * TRAILING SLASH REQUIRED.
     */
    public string $viewsPath = SYSTEMPATH . 'Debug/Toolbar/Views/';

    /**
     * --------------------------------------------------------------------------
     * Toolbar Max History
     * --------------------------------------------------------------------------
     *
     * The Toolbar stores its history in the cache. This setting determines
     * how many history items will be stored.
     */
    public int $maxHistory = 20;

    /**
     * --------------------------------------------------------------------------
     * Toolbar Collectors
     * --------------------------------------------------------------------------
     *
     * List of toolbar collectors that will be called when Debug Toolbar
     * fires up and collects data from.
     *
     * @var list<class-string>
     */
    public array $collectors = [
        'CodeIgniter\Debug\Toolbar\Collectors\Timers',
        'CodeIgniter\Debug\Toolbar\Collectors\Database',
        'CodeIgniter\Debug\Toolbar\Collectors\Logs',
        'CodeIgniter\Debug\Toolbar\Collectors\Views',
        'CodeIgniter\Debug\Toolbar\Collectors\Cache',
        'CodeIgniter\Debug\Toolbar\Collectors\Files',
        'CodeIgniter\Debug\Toolbar\Collectors\Routes',
        'CodeIgniter\Debug\Toolbar\Collectors\Events',
    ];

    /**
     * --------------------------------------------------------------------------
     * Collect Var Data
     * --------------------------------------------------------------------------
     *
     * If set to false var data from the views will not be collected. Useful to
     * avoid high memory usage when there are lots of data passed to the view.
     */
    public bool $collectVarData = true;

    /**
     * --------------------------------------------------------------------------
     * Max Queries
     * --------------------------------------------------------------------------
     *
     * If the number of queries exceeds this number, then the queries will not
     * be displayed in the Database collector.
     */
    public int $maxQueries = 100;

    /**
     * --------------------------------------------------------------------------
     * Watched Directories
     * --------------------------------------------------------------------------
     *
     * Contains an array of directories that will be watched for changes and
     * used to determine if the hot-reload feature should reload the page or not.
     * We restrict the values to keep performance as high as possible.
     *
     * NOTE: The ROOTPATH will be prepended to all values.
     *
     * @var list<string>
     */
    public array $watchedDirectories = [
        'app',
    ];

    /**
     * --------------------------------------------------------------------------
     * Watched File Extensions
     * --------------------------------------------------------------------------
     *
     * Contains an array of file extensions that will be watched for changes
     * and used to determine if the hot-reload feature should reload the page or not.
     *
     * @var list<string>
     */
    public array $watchedExtensions = [
        'php',
        'css',
        'js',
        'html',
        'svg',
        'json',
        'env',
    ];
}
