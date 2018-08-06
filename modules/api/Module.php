<?php

namespace app\modules\api;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::configure($this, require __DIR__ . '/config/config.php');
        // custom initialization code goes here
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; // this will return response in json 
        \Yii::$app->request->enableCsrfValidation = false; 
        \yii::$app->user->enableSession = false;
    }
}
