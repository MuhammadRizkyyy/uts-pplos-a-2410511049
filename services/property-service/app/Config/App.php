<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * Base URL aplikasi.
     */
    public string $baseURL = 'http://localhost:8002/';

    /**
     * Index file (kosongkan jika pakai .htaccess / rewrite).
     */
    public string $indexPage = '';

    public string $uriProtocol = 'REQUEST_URI';
    public string $defaultLocale = 'en';
    public bool $negotiateLocale = false;
    public array $supportedLocales = ['en'];
    public int $cookieLifetime = 0;
    public string $cookieDomain = '';
    public string $cookiePath = '/';
    public bool $cookieSecure = false;
    public bool $cookieHTTPOnly = false;
    public string $cookieSameSite = 'Lax';
    public string $cookiePrefix = '';
    public bool $CSRFProtection = false;
    public string $CSRFTokenName = 'csrf_token_name';
    public string $CSRFHeaderName = 'X-CSRF-TOKEN';
    public string $CSRFCookieName = 'csrf_cookie_name';
    public int $CSRFExpire = 7200;
    public bool $CSRFRegenerate = true;
    public bool $CSRFRedirect = false;
    public string $CSRFSameSite = 'Lax';
    public string $encryptionKey = '';
    public string $proxyIPs = '';
    public string $sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler';
    public string $sessionCookieName = 'ci_session';
    public int $sessionExpiration = 7200;
    public string $sessionSavePath = WRITEPATH . 'session';
    public bool $sessionMatchIP = false;
    public int $sessionTimeToUpdate = 300;
    public bool $sessionRegenerateDestroy = false;
    public int $passwordHashCost = 10;
}
