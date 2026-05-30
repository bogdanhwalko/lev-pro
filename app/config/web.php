<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => '/lev',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@images'   => '@app/../public_html/images',
    ],
    'components' => [
        'assetManager' => [
            // версія береться з params.php → 'assetVersion'
            // щоб скинути кеш у всіх браузерів — змінити число там
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'szpKF18YTFg7DqJ7b0mzxCZPMRZNWhuw',
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
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
                'sitemap.xml' => 'site/sitemap',
                '/' => 'site/index',
                'contact' => 'site/contact',
                'quick-contact' => 'site/quick-contact',
                'project-comment' => 'site/project-comment',
                'project/<slug:[\w-]+>' => 'site/project',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'gallery/<id:[\w-]+>/more' => 'gallery/more',
                'gallery/<id:[\w-]+>' => 'gallery/index',

                'admin' => 'admin/index',
                'admin/create' => 'admin/create',

                'admin/project' => 'project/index',
                'admin/project/create' => 'project/create',
                'admin/project/update/<id:\d+>' => 'project/update',
                'admin/project/delete/<id:\d+>' => 'project/delete',
                'admin/project/manage/<id:\d+>' => 'project/manage',
                'admin/project/post/<id:\d+>' => 'project/post-create',
                'admin/project/post-delete/<id:\d+>' => 'project/post-delete',
                'admin/project/photo-delete/<id:\d+>' => 'project/photo-delete',
                'admin/project/comment-delete/<id:\d+>' => 'project/comment-delete',
                'admin/project/comment-reply/<id:\d+>' => 'project/comment-reply',
                'admin/project/cover/<id:\d+>' => 'project/cover',
                'admin/project/cover-delete/<id:\d+>' => 'project/cover-delete',

                'admin/update/<id:\d+>' => 'admin/update',
                'admin/delete/<id:\d+>' => 'admin/delete',
                'admin/photos/<id:\d+>' => 'admin/photos',
                'admin/upload/<id:\d+>' => 'admin/upload',
                'admin/delete-photo/<id:\d+>' => 'admin/delete-photo',
            ],
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
