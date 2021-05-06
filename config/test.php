<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$router = require __DIR__ . '/router.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','queue'],
    'language' => 'ru-RU',
    'defaultRoute' => 'site/login',
    'homeUrl' => '/main',
    'name' => 'Паспорт жилищного фонда',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@mdm/admin' => '@app/widgets/yii2-admin',
        '@webroot' => '@app/web',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/admin.php',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                ]
            ],

        ]
    ],
    'components' => [
        'assetManager' => [

            'appendTimestamp' => true,
            'bundles' => [
                // 'yii\web\JqueryAsset' => false,
                //  'yii\bootstrap4\BootstrapPluginAsset' => false,
                'yii\bootstrap4\BootstrapAsset' => [
                    'css'=>[]
                ],
            ],
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries// Table name
            'as log' => \yii\queue\LogBehavior::class
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3W_d3T6Ddh2qRllqRlps1XXAlgW9vAFr',
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
        'authManager' => [
            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
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
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'categories' => ['yii\swiftmailer\Logger::add'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $router,
        ],

    ],

    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'debug/*',
            'gii/*',
            'admin/*'
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ],

    ],

    'params' => $params,
];
