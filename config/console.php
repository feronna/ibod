<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$db2 = require __DIR__ . '/db2.php';
$db3 = require __DIR__ . '/db3.php';
$db4 = require __DIR__ . '/db4.php';
$db5 = require __DIR__ . '/db5.php';
$db6 = require __DIR__ . '/db6.php';
$db7 = require __DIR__ . '/db7.php';
$db8 = require __DIR__ . '/db8.php';
$db9 = require __DIR__ . '/db9.php';
$db10 = require __DIR__ . '/db10.php';
$db11 = require __DIR__ . '/db11.php';
$db12 = require __DIR__ . '/db12.php';
$db13 = require __DIR__ . '/db13.php';
$db14 = require __DIR__ . '/db14.php';


$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'container' => [
        'singletons' => [
            'brussens\maintenance\StateInterface' => [
                'class' => 'brussens\maintenance\states\FileState',
                // optional: use different filename for controlling maintenance state:
                // 'fileName' => 'myfile.ext',
    
                // optional: use different directory for controlling maintenance state:
                // 'directory' => '@mypath',
            ]
        ]
    ],
    'controllerMap' => [
          'maintenance' => [
              'class' => 'brussens\maintenance\commands\MaintenanceController',
          ],
    ],
    'components' => [
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config 
            'tableName' => 'system_core.tbl_queue', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
            'ttr' => 14400,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\hronline\Tblprcobiodata',
            'enableAutoLogin' => false,
            'authTimeout' => 1800,
            'enableSession' => false,
        ],
        'MP' => [
            'class' => 'app\components\MaklumatPeribadi',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'class' => 'yii\web\Session',
            'name' => 'hrv4',
            'timeout' => 60 * 60 * 24 * 14,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                //                'username' => 'cuti.hronline@ums.edu.my', //kasi rehat dlu ni email
                //                'password' => 'Cuti@HRonlineBSM321',
                'username' => 'eoffice.ums@ums.edu.my',
                'password' => 'A4pzuun*',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'mailer3' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                //                'host' => '10.50.0.243',
                'username' => 'pengajianlanjutan@ums.edu.my',
                'password' => 'sabahGr3@t',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'mailerEpos' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                //                'host' => '10.50.0.243',
                'username' => 'pengajianlanjutan@ums.edu.my',
                'password' => 'sabahGr3@t',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'db2' => $db2,
        'db3' => $db3,
        'db4' => $db4,
        'db5' => $db5,
        'db6' => $db6,
        'db7' => $db7,
        'db8' => $db8,
        'db9' => $db9,
        'db10' => $db10,
        'db11' => $db11,
        'db12' => $db12,
        'db13' => $db13,
        'db14' => $db14,
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
