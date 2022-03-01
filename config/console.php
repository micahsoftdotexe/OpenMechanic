<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            // Using DbManager
            'class' => 'yii\rbac\DbManager',
            'defaultRoles'   => ['employee'],  // Default roles for a user (added in addition to assigned roles)

            // Using PhpManager
            //'class' => 'yii\rbac\PhpManager',
            //'defaultRoles'   => ['registered'],  // Default roles for a user (added in addition to assigned roles)
            // // By default, yii\rbac\PhpManager stores RBAC data in files under @app/rbac/ directory.
            // // Make sure that directory is web writable.
            // 'itemFile'       => '@app/rbac/data/items.php',                // Default path to items.php
            // 'assignmentFile' => '@app/rbac/data/assignments.php',          // Default path to assignments.php
            // 'ruleFile'       => '@app/rbac/data/rules.php',                // Default path to rules.php
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
