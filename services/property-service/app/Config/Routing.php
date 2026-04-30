<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Routing extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Default Namespace
     * --------------------------------------------------------------------------
     *
     * Default namespace to use for Controllers when no other namespace has been
     * specified.
     */
    public string $defaultNamespace = 'App\Controllers';

    /**
     * --------------------------------------------------------------------------
     * Default Controller
     * --------------------------------------------------------------------------
     *
     * The name of the default controller that is used when no other controller
     * is specified.
     *
     * This value must match the name of the controller class exactly.
     */
    public string $defaultController = 'Home';

    /**
     * --------------------------------------------------------------------------
     * Default Method
     * --------------------------------------------------------------------------
     *
     * The name of the default method that is used when no other method has been
     * specified.
     */
    public string $defaultMethod = 'index';

    /**
     * --------------------------------------------------------------------------
     * Translate URI Dashes
     * --------------------------------------------------------------------------
     *
     * Determines whether dashes in controller & method segments should be
     * automatically replaced by underscores when locating the controller.
     */
    public bool $translateURIDashes = false;

    /**
     * --------------------------------------------------------------------------
     * Override HTTP Verb
     * --------------------------------------------------------------------------
     *
     * If true, this will enable the X-HTTP-Method-Override header to be used
     * to determine the method, in addition to the _method form data.
     */
    public bool $overrideMethod = true;

    /**
     * --------------------------------------------------------------------------
     * Auto Route (Improved)
     * --------------------------------------------------------------------------
     *
     * If true, the system will attempt to match the URI against Controllers by
     * matching each segment against folders/files in APPPATH/Controllers,
     * when a match wasn't found against defined routes.
     */
    public bool $autoRoute = false;

    /**
     * --------------------------------------------------------------------------
     * Auto Route (Legacy)
     * --------------------------------------------------------------------------
     *
     * If true, the system will attempt to match the URI against Controllers by
     * matching each segment against folders/files in APPPATH/Controllers,
     * when a match wasn't found against defined routes.
     *
     * WARNING: This option is deprecated. Use $autoRoute instead.
     */
    public bool $autoRouteLegacy = false;

    /**
     * --------------------------------------------------------------------------
     * 404 Override
     * --------------------------------------------------------------------------
     *
     * This option allows you to override the default 404 page that CodeIgniter
     * has. You can specify a controller/method pair or a callable.
     *
     * @var array|Closure|string|null
     */
    public $override404 = null;

    /**
     * --------------------------------------------------------------------------
     * Prioritize
     * --------------------------------------------------------------------------
     *
     * When set to true, this will give priority to routes that are defined
     * later in the routes file. When false, it will give priority to routes
     * defined earlier.
     */
    public bool $prioritize = false;

    /**
     * --------------------------------------------------------------------------
     * Multiple URI Segments
     * --------------------------------------------------------------------------
     *
     * When set to true, this will allow multiple URI segments to be passed to
     * the controller method as separate parameters.
     */
    public bool $multipleSegmentsOneParam = false;

    /**
     * --------------------------------------------------------------------------
     * Route Files
     * --------------------------------------------------------------------------
     *
     * The route files that should be loaded.
     *
     * @var list<string>
     */
    public array $routeFiles = [
        APPPATH . 'Config/Routes.php',
    ];

    /**
     * --------------------------------------------------------------------------
     * Use Controller Attributes
     * --------------------------------------------------------------------------
     *
     * If true, the system will scan controllers for route attributes.
     */
    public bool $useControllerAttributes = false;
}
