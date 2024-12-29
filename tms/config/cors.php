<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths to Apply CORS Middleware
    |--------------------------------------------------------------------------
    |
    | Here you define the paths where CORS should be applied. You can add your
    | API routes and any other endpoints that require cross-origin access.
    |
    */
    'paths' => ['api/*', 'graphql', 'sanctum/csrf-cookie'],

    /*
    |--------------------------------------------------------------------------
    | Allowed HTTP Methods
    |--------------------------------------------------------------------------
    |
    | Specify which HTTP methods are allowed for cross-origin requests. Use ['*']
    | to allow all methods, or define a specific list like ['GET', 'POST', 'OPTIONS'].
    |
    */
    'allowed_methods' => ['*'], // ['GET', 'POST', 'OPTIONS'] for stricter control.

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Here you can define the origins that are allowed to access your resources.
    | Use ['*'] for all origins, or list specific domains for production.
    |
    */
    'allowed_origins' => ['*', 'http://localhost:3000'], // Replace '*' with specific domains in production.

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins Patterns
    |--------------------------------------------------------------------------
    |
    | If you need to allow origins based on wildcard patterns (e.g., *.example.com),
    | you can use this option. This is useful for subdomains.
    |
    */
    'allowed_origins_patterns' => [ 'http://localhost:3000/*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | Specify which headers can be used during cross-origin requests. Use ['*']
    | to allow all headers, or list specific ones (e.g., ['Content-Type', 'Authorization']).
    |
    */
    'allowed_headers' => ['*'], // Replace '*' with a list like ['Content-Type', 'Authorization'].

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | These are the headers that will be exposed to the browser. Typically, you don't
    | need to expose any custom headers unless required.
    |
    */
    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Maximum Age
    |--------------------------------------------------------------------------
    |
    | This sets how long the preflight response (OPTIONS request) can be cached
    | by the client, in seconds. A value of 0 disables caching.
    |
    */
    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | When true, this allows credentials (like cookies, authorization headers, or TLS
    | client certificates) to be included in cross-origin requests. This should be
    | enabled only when absolutely necessary.
    |
    */
    'supports_credentials' => false, // Change to true if cookies or authentication headers are required.

];
