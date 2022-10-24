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
];