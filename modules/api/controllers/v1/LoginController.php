<?php 
namespace app\modules\api\controllers\v1;
use Yii; 
use yii\filters\VerbFilter; 
class LoginController extends \yii\rest\ActiveController
{
	public $modelClass = 'dektrium\user\models\User';
	public function behaviors()
    {
        return [ 
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [ 
                    'do-login'=>['post']

                ],
            ],
        ];
    } 

    public function fields()
    {
    	return parent::fields();
    }

    public function extraFileds()
    {
    	//return parent::extraFileds();
    }

    public function actions()
    { 
    	$action = parent::actions();
        unset($action['index']);
        return $action;
    }
	public function actionDoLogin()
	{    
		$attributes = \yii::$app->request->post(); 
        if(isset($attributes['email']) && isset($attributes['password']) && isset($attributes['location']))
        {
            $obj = \Yii::createObject($this->modelClass);
            $model = $obj::find()->where(['username' => $attributes['email']])->orWhere(['email' => $attributes['email']])->one(); 
            if($model)
            {
               if (Yii::$app->getSecurity()->validatePassword($attributes['password'], $model->password_hash )) {
                     if($model->isConfirmed)
                     {
                        Yii::$app->user->login($model);
                        if(Yii::$app->user->can('employee'))
                        {
                            $modelLocation = new \app\models\UserLoginLocation();
                            $modelLocation->location = $attributes['location'];
                            $modelLocation->user_id = $model->id;
                            $modelLocation->save();
                            return [
                                'status' => 'true', 
                                'data' => [ 
                                    "message" => "Login successful",
                                    'id' => $model->auth_key
                                ]
                            ];
                        }
                        return ['status' => 'false', 'data' => [ "message" => "User not an employee", 'id' => '']];
                     }
                     return ['status' => 'false', 'data' => [ "message" => "Acoount not verified", 'id' => '']];
                }
                return ['status' => 'false', 'data' => [ "message" => "wrong password", 'id' => '']]; 
            }
            return ['status' => 'false', 'data' => [ "message" => "Wrong credential", 'id' => '']];  
        }
        return ['status' => 'false', 'data' => [ "message" => "Access denied", 'id' => '']];
	}
}
?>