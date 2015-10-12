<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info'],
                    'except' => ['yii\db*']
                ],

                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'except' => ['yii\db*']
                ],
            ],
        ],

        'user' => [
            'class'=>'app\components\ConsoleUser',

        ],
        'authManager'          => [
            'class'        => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],

        'db' => $db,
    ],
    'params' => $params,
];
