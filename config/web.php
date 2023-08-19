<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$urlRules = require __DIR__ . '/urlRules.php';

$baseUrl = str_replace('/web', '', (new \yii\web\Request)->getBaseUrl());
$config = [
    'id' => 'basic',
    'homeUrl' => $baseUrl . "/",
    'name' => "TuneUp",
    'basePath' => dirname(__DIR__),
    'timeZone' => $params['timezone'],
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'jwt' => [
            'class' => \bizley\jwt\Jwt::class,
            'signer' => \bizley\jwt\Jwt::HS256,
            'signingKey' => [
                'key' => 'z$C&F)J@NcRfUjXn2r4u7x!A%D*G-KaP' //typically a long random string
            ],
            //'key' => 'SECRET-KEY',  //typically a long random string
            'validationConstraints' => static function (\bizley\jwt\Jwt $jwt) {
                $config = $jwt->getConfiguration();
                // Yii::debug(new \Lcobucci\Clock\SystemClock(new \DateTimeZone(\Yii::$app->timeZone)), 'dev');
                return [
                    new \Lcobucci\JWT\Validation\Constraint\SignedWith($config->signer(), $config->signingKey()),
                    new \Lcobucci\JWT\Validation\Constraint\StrictValidAt(
                        new \Lcobucci\Clock\SystemClock(new \DateTimeZone(\Yii::$app->timeZone))
                    ),
                ];
            }
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            //'baseUrl' => $baseUrl,
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'hzJV8U73FbLMy1AWITd5rWYwHE1sCDRd',
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'dev'=> [   // Logs for 'dev' category only
                    // Usage: \Yii::trace("hi there", 'dev');  // log something
                    //        Yii::$app->log->targets['dev']->enabled = false;  // disable log target
                    'class'      => 'yii\log\FileTarget',
                    'levels'     => ['info', 'trace', 'error', 'warning'],
                    'categories' => ['dev'],
                    'logVars'    => [],
                    'logFile'    => '@runtime/logs/dev.log',
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            //'baseUrl'         => $baseUrl,
            'enableStrictParsing' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'pluralize' => false,
            'rules' => $urlRules,
        ],
        'authManager' => [
            // Using DbManager
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles'   => ['employee'],  // Default roles for a user (added in addition to assigned roles)

            // Using PhpManager
            //'class' => 'yii\rbac\PhpManager',
            //'defaultRoles'   => ['registered'],  // Default roles for a user (added in addition to assigned roles)
            // // By default, yii\rbac\PhpManager stores RBAC data in files under @app/rbac/ directory.
            // // Make sure that directory is web writable.
            // 'itemFile'       => '@app/rbac/data/items.php',                // Default path to items.php
            // 'assignmentFile' => '@app/rbac/data/assignments.php',          // Default path to assignments.php
            // 'ruleFile'       => '@app/rbac/data/rules.php',                // Default path to rules.php
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '10.243.43.106'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
