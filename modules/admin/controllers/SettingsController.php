<?php
namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\helpers\Configuration;
use yii\web\NotFoundHttpException;
class SettingsController extends Controller
{ 

    public function actionSkin()
    {    
            $request=Yii::$app->request;
            if($request->isAjax){
                $skin=$request->getBodyParam('id');
                $save=Configuration::updateSiteData(Configuration::DEFAULT_SKIN,$skin);
                if($save){
                    return $this->goBack();
                    return json_encode("Skin has been changed");
                } else {
                    throw new NotFoundHttpException('The requested page dose not exist.');
                }           
            }else{
                return false;
            }  
    }
	public function actionConfig()
	{
		$req = Yii::$app->request;
        if(!$req->isAjax){
            throw new NotFoundHttpException("Page not found");
        }
        $params = $req->getBodyParams();
        $valid = false;
            foreach ($params as $paramKey=>$param){
                $save = Configuration::updateSiteData($paramKey,$param);
                if($save){
                    $valid = true;
                }

            }
            if($valid){
               // $this->flush();
               // return "saved";
            	return $this->goBack();
            }
	}  
}
?>