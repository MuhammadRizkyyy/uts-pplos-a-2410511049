<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class View extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Save Data
     * --------------------------------------------------------------------------
     *
     * When false, the view data will be cleared between each call to the view.
     * This keeps your data fresh, but can be a problem if you need to use the
     * same data in multiple views.
     */
    public bool $saveData = true;

    /**
     * --------------------------------------------------------------------------
     * Filters
     * --------------------------------------------------------------------------
     *
     * Filters are used to process the output of a view before it is sent to
     * the browser. By default, CodeIgniter will use the Filters class to
     * process the output.
     *
     * @var array<string, string>
     */
    public array $filters = [];

    /**
     * --------------------------------------------------------------------------
     * Plugins
     * --------------------------------------------------------------------------
     *
     * Plugins are used to extend the functionality of the View class.
     *
     * @var array<string, string>
     */
    public array $plugins = [];
}
