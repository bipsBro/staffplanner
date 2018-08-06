<?php 
namespace app\modules\api\controllers\v1;
use Yii; 
class NewsController extends \yii\rest\ActiveController
{
	public $modelClass = 'app\models\News'; 

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
    public function actionListNews()
    {
    	$obj = \Yii::createObject($this->modelClass);
    	$model = $obj::find()->select('id, title, expired_date, description')->where(['>', 'expired_date', date("Y-m-d")])->all();
    	if($model)
    	{
    		return ['status' => 'true', 'data' => $model];
    	} 
    	return ['status' => false, 'data' => "No news found"];
    }
}
?>