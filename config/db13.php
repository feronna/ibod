<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=10.50.9.172;port=3307;dbname=moodlev3',
    'username' => 'sys_hr',
    'password' => 'hr5m@rt2020',
//    'dsn' => 'mysql:host=localhost;dbname=moodlev3',
//    'username' => 'root',
//    'password' => '',
    'charset' => 'utf8',
    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
