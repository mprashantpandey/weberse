<?php

return [
    'base_url' => env('WHMCS_BASE_URL') ?: rtrim(env('APP_URL', 'http://localhost'), '/') . '/billing',
    'identifier' => env('WHMCS_API_IDENTIFIER'),
    'secret' => env('WHMCS_API_SECRET'),
    'access_key' => env('WHMCS_ACCESS_KEY'),
    'sso_redirect' => env('WHMCS_SSO_REDIRECT', '/clientarea.php'),
    'timeout' => (int) env('WHMCS_TIMEOUT', 10),
    'cache_ttl' => (int) env('WHMCS_CACHE_TTL', 300),
];
