<?php

namespace Config;

use CodeIgniter\Modules\Modules as BaseModules;

class Modules extends BaseModules
{
    /**
     * --------------------------------------------------------------------------
     * Enable Auto-Discovery?
     * --------------------------------------------------------------------------
     *
     * If true, then auto-discovery will happen across all elements listed in
     * $activeExplorers below. If false, no auto-discovery will happen at all,
     * giving a slight performance boost.
     */
    public $enabled = true;

    /**
     * --------------------------------------------------------------------------
     * Auto-Discovery Within Composer Packages?
     * --------------------------------------------------------------------------
     *
     * If true, then auto-discovery will happen across all namespaces loaded
     * by Composer, as well as the namespaces configured locally.
     */
    public $discoverInComposer = true;

    /**
     * --------------------------------------------------------------------------
     * Composer Packages
     * --------------------------------------------------------------------------
     *
     * Lists the composer packages that contain additional modules to auto-discover.
     */
    public $composerPackages = [];

    /**
     * --------------------------------------------------------------------------
     * Auto-discover Rules
     * --------------------------------------------------------------------------
     *
     * Lists the aliases of all discovery classes that will be active
     * and used during the current application request.
     *
     * If it is not listed here, only the base application elements will be used.
     */
    public $aliases = [
        'events',
        'filters',
        'registrars',
        'routes',
        'services',
    ];
}
