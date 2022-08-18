<?php

Yii::setAlias('@uploadpendidikan', 'http://10.50.12.83/staff/web/uploads/hronline/pendidikan');

return [
    'adminEmail' => 'admin@example.com',
    'pelulusICNO' => '811212125745',
    'mdm.admin.configs' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=system_core',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',

            // Schema cache options (for production environment)
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
    ]
];
