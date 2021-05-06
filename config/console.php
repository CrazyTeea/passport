<?php

use yii\mutex\MysqlMutex;
use yii\queue\db\Queue;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' =>  ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@mdm/admin' => '@app/widgets/yii2-admin',
        '@tests' => '@app/tests',
        '@webroot' => '@app/web',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'queue' => [
            'channel' => 'default',
            'class' => Queue::class,      // Queue channel key
            'db' => 'db',                 // DB connection component or its config
            'mutex' => MysqlMutex::class, // Mutex used to sync queries,
            'tableName' => '{{%queue}}',   // Table name
            'as log' => \yii\queue\LogBehavior::class
        ],
         'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mirea.ru',//getenv('MAIL_HOST'),
                'username' => 'lipatov_n@mirea.ru',
                'password' => getenv('MAIL_PASSWORD'),
                'port' => getenv('MAIL_PORT'),
                'encryption' => 'tls',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['lipatov_n@mirea.ru' => 'ИАС Мониторинг'],
            ],


            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
