<?php 
namespace app\modules\api\controllers\v1;
use Yii; 
class InformationController extends \yii\rest\ActiveController
{
	public $modelClass = 'app\models\Information'; 

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
    public function actionListInformation()
    {
    	$obj = \Yii::createObject($this->modelClass);
    	$model = $obj::find()->where(['status' => \app\helpers\Configuration::ACTIVE])->all();
    	if($model)
    	{
    		return ['satus' => 'true', 'data' => $model];
    	} 
    	return ['status' => false, 'data' => "No information found"];
    }
}
?>