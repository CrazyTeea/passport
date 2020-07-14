<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'defaultRoute'=>'site/login',
    'homeUrl'=>'/main',
    'name'=>'Паспорт жилищного фонда',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@mdm/admin' => '@app/widgets/yii2-admin',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
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
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'main'=>'app/passport',
                'org-info'=>'app/passport/org-info',
                'area-info'=>'app/passport/area-info',
                'living-info'=>'app/passport/living-info',
                'living-info-inv'=>'app/passport/living-info-inv',

                'objects-info'=>'app/objects/object',
                'objects-area'=>'app/objects/area',
                'objects-tariff'=>'app/objects/tariff',
                'objects-money'=>'app/objects/money',
                'documents'=>'app/documents',

                'api/user/current'=>'api/user/get-current',
                'api/user/info/<id_org:\d+>'=>'api/user/info',
                'api/regions'=>'api/regions/all',

                'api/get-doc-types/<id_org:\d+>'=>'api/organizations/get-doc-types',

                'api/organization/by-id/<id:\d+>'=>'api/organizations/get-org',
                'api/organization/users/<id:\d+>'=>'api/organizations/users-info',


                'api/objects/org/<id_org:\d+>'=>'api/objects/by-org',

                'organization/users-info/<id:\d+>'=>'app/organizations/users-info',
                'organization/users-info/<id:\d+>/delete'=>'app/organizations/delete-users-info',

                'organization/set-org-info/<id:\d+>'=>'app/organizations/set-org-info',
                'organization/set-org-area/<id:\d+>'=>'app/organizations/set-org-area',
                'organization/set-org-living/<id:\d+>'=>'app/organizations/set-org-living',

                'object/create/<id_org:\d+>'=>'app/objects/create',
                'object/update/<id:\d+>'=>'app/objects/update',
                'object/set-area/<id:\d+>'=>'app/objects/set-area',
                'object/set-money/<id:\d+>'=>'app/objects/set-money',
                'object/set-tariff/<id:\d+>'=>'app/objects/set-tariff'


            ],
        ],

    ],

    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'debug/*',
            //'admin/*',
            //'admin/*'
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
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
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
