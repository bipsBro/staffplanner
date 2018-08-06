<?php 
namespace app\modules\api\controllers;
use Yii;
use yii\web\Controller;
use app\models\News;
class NewsController extends Controller
{
	public function actionIndex()
	{
		return ['status' => 'false', 'data' => 'Access denied'];
	}

	public function actionAllNews()
	{ 
		$getNews = News::find()->select('id, title, expired_date, description')->where(['>', 'expired_date', date("Y-m-d")])->all();
		return ['satus' => 'true', 'data' => $getNews];

	}
}
?>