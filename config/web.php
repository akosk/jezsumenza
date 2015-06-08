<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'language'   => 'hu-HU',
    'bootstrap'  => ['log'],
    'modules'    => [
        'user'     => [
            'class'              => 'dektrium\user\Module',
            'enableConfirmation' => false,
            'admins'             => ['akosk'],

            'controllerMap'      => [
                'admin' => 'app\controllers\AdminController',
                'security' => 'app\controllers\SecurityController',
            ],

            'modelMap'           => [
                'User'       => 'app\models\User',
                'Profile'    => 'app\models\Profile',
                'UserSearch' => 'app\models\UserSearch',
            ],
        ],
        'rbac'     => [
            'class' => 'dektrium\rbac\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            'i18n'  => [
                'class'            => 'yii\i18n\PhpMessageSource',
                'basePath'         => '@app/messages',
                'forceTranslation' => true
            ]
        ]
    ],
    'components' => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'IDNNZc7GCYB-O3Dz_2v-NVLddUvecZNQ',
            'enableCsrfValidation'=>false,
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,

        ],
        'i18n'         => [
            'translations' => [
                'user*' => [
                    'class'   => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class'  => 'app\components\DbTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],

        'authManager'  => [
            'class'        => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => true,
//            'enableStrictParsing' => false,
//            'rules'               => [
//                '<module:\w+>/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => '<module>/<controller>/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>'          => '<module>/<controller>/<action>',
//                '<controller:\w+>/<action:\w+>/<id:\d+>'              => '<controller>/<action>',
//                '<controller:\w+>/<action:\w+>'                       => '<controller>/<action>',
//                ''                                                    => '/site/index',
//            ],
        ],
        'view'         => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],

        'db'           => require(__DIR__ . '/db.php'),
    ],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
