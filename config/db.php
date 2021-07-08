<?php
$db = [
    'charset' => 'utf8',
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=workorder',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

if (file_exists(__DIR__ . '/db-local.php')) {
    $db = array_merge($db, require(__DIR__ . '/db-local.php'));
}

return $db;
