<?php

return [
    'base_url' => env('API_BASE_URL', 'http://localhost:8000/api'),
    'timeout' => env('API_TIMEOUT', 30),
    'token' => env('API_TOKEN', null),
    
    'endpoints' => [
        'projects' => [
            'index' => '/projects',
            'show' => '/projects/{id}',
            'store' => '/projects',
            'update' => '/projects/{id}',
            'destroy' => '/projects/{id}',
        ],
        'tasks' => [
            'index' => '/tasks',
            'show' => '/tasks/{id}',
            'store' => '/tasks',
            'update' => '/tasks/{id}',
            'destroy' => '/tasks/{id}',
            'complete' => '/tasks/{id}/complete',
        ],
    ],
];