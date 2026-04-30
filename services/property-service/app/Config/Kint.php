<?php

namespace Config;

use Kint\Parser\ConstructablePluginInterface;
use Kint\Renderer\AbstractRenderer;
use Kint\Renderer\Rich\TabPluginInterface;
use Kint\Renderer\Rich\ValuePluginInterface;

/**
 * Kint Configuration
 *
 * These are the settings for Kint debugging library.
 */
class Kint
{
    /*
    |--------------------------------------------------------------------------
    | Global Settings
    |--------------------------------------------------------------------------
    */

    public int $maxDepth = 6;
    public bool $displayCalledFrom = true;
    public bool $expanded = false;
    public string $richTheme = 'aante-light.css';
    public bool $richSort = false;
    public array $richObjectPlugins = [];
    public array $richTabPlugins = [];
    public bool $richFolder = false;
    public bool $cliColors = true;
    public bool $cliForceUTF8 = false;
    public bool $cliDetectWidth = true;
    public int $cliMinWidth = 40;

    /**
     * @var array<string, mixed>
     */
    public array $globals = [];

    /*
    |--------------------------------------------------------------------------
    | Application Specific Settings
    |--------------------------------------------------------------------------
    */

    /**
     * @var array<string, mixed>
     */
    public array $appSettings = [];

    /**
     * @var list<class-string<ConstructablePluginInterface>>
     */
    public array $plugins = [];

    /**
     * @var array<string, class-string<AbstractRenderer>>
     */
    public array $renderers = [];

    /**
     * @var list<class-string<TabPluginInterface>>
     */
    public array $richTabs = [];

    /**
     * @var list<class-string<ValuePluginInterface>>
     */
    public array $richValuePlugins = [];
}
