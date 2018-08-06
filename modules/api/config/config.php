<?php 


$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),  
    'components' => [
        'request' => [
            'class' => "yii\web\Request",
            /*'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]*/
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'login'],
            ],
        ]
     ],
];
 

return $config;
