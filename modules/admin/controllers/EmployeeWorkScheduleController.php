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
class EmployeeWorkScheduleController extends Controller
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

    /**
     * Creates a new EmployeeWorkSchedule model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $request = Yii::$app->request;
        $model = new EmployeeWorkSchedule();  
        $model->schedule_id = $id;
        $model->request_type  = \app\helpers\Configuration::ADMIN_CREATED;
        $model->status = \app\helpers\Configuration::APPROVED; 

        $modelSchedule = \app\models\WorkSchedule::findOne($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new EmployeeWorkSchedule",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                $modelEmployee = \app\models\Employee::findOne($model->emp_id);
                $modelEmployee->hour_worked = ($modelEmployee->hour_worked + $modelSchedule->minutes)/60;
                $modelEmployee->save(false);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new EmployeeWorkSchedule",
                    'content'=>'<span class="text-success">Create EmployeeWorkSchedule success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]) 
        
                ];         
            }else{           
                return [
                    'title'=> "Create new EmployeeWorkSchedule",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
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
