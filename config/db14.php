<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:Server=10.50.9.90;Database=smpspu',
    'username' => 'hr_cvonline',
    'password' => 'cv0nl1n32016',
//    'dsn' => 'mysql:host=localhost;dbname=hronline',
//    'username' => 'root',
//    'password' => '',
    // 'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
