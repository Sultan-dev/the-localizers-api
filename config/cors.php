<?php

return [
  'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],

  'allowed_methods' => ['*'],

  'allowed_origins' => [
    'http://localhost:3000',
    'http://127.0.0.1:3000',
    'http://192.168.1.129:3000', // IP جهازك
    'http://localhost:5173',
    'http://127.0.0.1:5173',
    'http://192.168.1.129:5173',
    'https://ai.thelocalizers.com',
    'https://dashboard.thelocalizers.com',
    'http://34.1.49.37',
    'https://34.1.49.37',
    'http://34.1.58.158',
    'https://34.1.58.158',
    'http://34.1.58.14',
    'https://34.1.58.14',
  ],

  'allowed_origins_patterns' => [
    '/^http:\/\/localhost:\d+$/',
    '/^http:\/\/127\.0\.0\.1:\d+$/',
    '/^http:\/\/192\.168\.1\.\d+:\d+$/',
  ],

  'allowed_headers' => ['*'],
  'exposed_headers' => [],
  'max_age' => 0,

  // بما أنك تستخدم Bearer Token و withCredentials:false:
  'supports_credentials' => false,
];