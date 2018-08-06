<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\EmployeeWorkSchedule;
use app\models\search\EmployeeWorkScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\helpers\Configuration;

/**
 * EmployeeWorkScheduleController implements the CRUD actions for EmployeeWorkSchedule model.
 */
class EmployeeRequestController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all EmployeeWorkSchedule models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new EmployeeWorkScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status' => Configuration::PENDING]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single EmployeeWorkSchedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "EmployeeWorkSchedule #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]) 
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
 

     public function actionApprove($id)
    {    
        $model = EmployeeWorkSchedule::find()->where(['id' => $id, 'status' => Configuration::PENDING])->one();
        if(!$model)
        {    
            \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'This request is already approved')); 
            return $this->redirect(Yii::$app->request->referrer);  
        } 
        if($this->changeStatus($id, $model->schedule->date, $model->schedule->start_time, $model->schedule->end_time, Configuration::APPROVED))
        { 
           \Yii::$app->getSession()->setFlash('success', yii::t('app', 'Status approved successfully')); 
        } 
        else
        {
            \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'Email not send'));
        }   
        return $this->redirect(Yii::$app->request->referrer);     
    }
    public function actionDecline($id)
    {    
        $model = EmployeeWorkSchedule::find()->where(['id' => $id, 'status' => Configuration::PENDING])->one();
        if(!$model)
        {    
            \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'This request is already approved')); 
            return $this->redirect(Yii::$app->request->referrer);  
        } 
        if($this->changeStatus($id, $model->schedule->date, $model->schedule->start_time, $model->schedule->end_time, Configuration::DECLINED))
        { 
           \Yii::$app->getSession()->setFlash('success', yii::t('app', 'Status declined successfully')); 
        } 
        else
        {
            \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'Email not send'));
        }   
        return $this->redirect(Yii::$app->request->referrer);     
    }
 

    protected function changeStatus($id, $date, $start_time, $end_time, $status)
    {
        $model = EmployeeWorkSchedule::findOne($id);
        $email = $model->emp->getEmail();  
        $model->status = $status;  
        $model->save(); 
        return $this->sendMail($date, $start_time, $end_time, $email,Configuration::getStatus($status));  
    }

    protected function sendMail($date, $start_time, $end_time, $email, $status)
    {
        $setSubject = "Your schedule status is updated";
        $setHtmlBody = "Your schedule request [".$date." / (".$start_time." - ".$end_time.")] has been ".$status." by admin.";
        return \app\helpers\Send_email::send($email, $setSubject, $setHtmlBody);  
        
    }

    /**
     * Finds the EmployeeWorkSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployeeWorkSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployeeWorkSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
