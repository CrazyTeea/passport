<?php
return [
    'root' => [
        'type' => 1,
        'children' => [
            '/*',
        ],
    ],
    '/*' => [
        'type' => 2,
    ],
    'admin' => [
        'type' => 1,
    ],
    'user' => [
        'type' => 1,
        'children' => [
            '/app/passport/*',
            '/app/organizations/*',
            '/app/objects/*',
            '/app/documents/*',
            '/api/user/*',
            '/api/regions/*',
            '/api/organizations/*',
            '/api/objects/*',
        ],
    ],
    '/app/passport/*' => [
        'type' => 2,
    ],
    '/app/organizations/*' => [
        'type' => 2,
    ],
    '/app/objects/*' => [
        'type' => 2,
    ],
    '/app/documents/*' => [
        'type' => 2,
    ],
    '/api/user/*' => [
        'type' => 2,
    ],
    '/api/regions/*' => [
        'type' => 2,
    ],
    '/api/organizations/*' => [
        'type' => 2,
    ],
    '/api/objects/*' => [
        'type' => 2,
    ],
];
