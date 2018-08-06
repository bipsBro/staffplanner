<?php
use yii\web\Request;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$baseURL=str_replace('/web','',(new Request)->getBaseUrl());


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Kathmandu',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'view' =>[
              'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/users',  
                ],
           ],
       ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'online@#!43221cleanign!@#$%',
            'baseUrl' => $baseURL,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        
       'setting' => [
            'class' => 'app\helpers\Setting'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager'  => [
                'class'        => '\dektrium\rbac\components\DbManager', 
        ],
        'user' => [
            'identityClass' => \dektrium\user\models\User::className(),
            'enableAutoLogin' => true,
        ], 
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                //'viewPath' => 'mail/layouts/html.php',
                'useFileTransport' => false,
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => gethostbyname('smtp.gmail.com'), 
                            'username' => 'alexmonro334@gmail.com',
                            'password' => 'monro123',
                    'port' => '465',
                    'encryption' => 'ssl',
                     'streamOptions' => [ 'ssl' =>
                            [ 'allow_self_signed' => true,
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                            ],
                        ]
                ],
                'messageConfig' => [
                            'charset' => 'UTF-8',
                    ],
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
            ],
        ],
        
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'layout'=>'../../../../../modules\admin\views\layouts\main', 
            'enableUnconfirmedLogin' => true,
            'admins'=> ['developer'], 
            'modelMap' => [
                        'User' => 'app\models\User',  
                    ],

            'controllerMap' => [
                'userAction' => 'app\controllers\user\AdminController'
            ],        
        ],
        'rbac' => [
             'class' => 'dektrium\rbac\RbacWebModule', 
             'layout'=>'../../../../../modules\admin\views\layouts\main', 
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => 'main'
        ],
        'developer' => [
            'class' => 'app\modules\developer\Module', 
        ],
        'api' => [
            'class' => 'app\modules\api\Module',
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
        'generators' => [ //here
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                ]
            ]
        ],
    ];
}

return $config;
