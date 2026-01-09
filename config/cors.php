<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => ['http://localhost:5174'],
'allowed_headers' => ['*'],
 
 
 

    'allowed_origins_patterns' => [],

 
    'exposed_headers' => ['*'],

    'max_age' => 3600,

    'supports_credentials' => true,
];
