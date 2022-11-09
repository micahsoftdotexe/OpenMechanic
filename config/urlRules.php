<?php
return [
    // 'GET user/list' => 'user/listUser'
    [
        'pattern' => 'user/list-user',
        'route' => 'user/list-current-user'
    ],
    [
        'pattern' => 'auth/login',
        'route' => 'user/login'
    ],
    [
        'pattern' => 'auth/refresh',
        'route' => 'user/refresh-token'
    ],
    [
        'pattern' => 'customer/list',
        'route' => 'customer/list'
    ]
];