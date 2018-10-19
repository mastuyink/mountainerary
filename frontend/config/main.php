<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'defaultRoute'=> '/web/index',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        // 'user' => [
        //     'identityClass' => 'common\models\User',
        //     'enableAutoLogin' => true,
        //     'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        // ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'web/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/about-us' => '/web/about-us',
                '/contact-us' => '/web/contact-us',
                //'package/all-package'                      => '/package/all-package',
                '<controller:(package)>/<category>/<slug>' => '/package/category',
                '<controller:(package)>/<category>'        => '/package/category',
                //'<controller:(package)>/<action>'          => '/<action>',
                //'<controller:(package)>/<action:(galery)>/<id:\d+>' => '/package/galery',
                '<controller:[\w\-]+>/<action:[\w\-]+>'    => '<controller>/<action>',
            ],
            'normalizer'=>[
                'class'                  => 'yii\web\UrlNormalizer',
                'collapseSlashes'        => true,
                'normalizeTrailingSlash' => true,
            ]
        ],
        
    ],
    'params' => $params,
];
