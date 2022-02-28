<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'authManager' => [
            // Using DbManager
            'class' => 'yii\rbac\DbManager',
            'defaultRoles'   => ['registered'],  // Default roles for a user (added in addition to assigned roles)

            // Using PhpManager
            //'class' => 'yii\rbac\PhpManager',
            //'defaultRoles'   => ['registered'],  // Default roles for a user (added in addition to assigned roles)
            // // By default, yii\rbac\PhpManager stores RBAC data in files under @app/rbac/ directory.
            // // Make sure that directory is web writable.
            // 'itemFile'       => '@app/rbac/data/items.php',                // Default path to items.php
            // 'assignmentFile' => '@app/rbac/data/assignments.php',          // Default path to assignments.php
            // 'ruleFile'       => '@app/rbac/data/rules.php',                // Default path to rules.php
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
