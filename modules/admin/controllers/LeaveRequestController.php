<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\LeaveRequest;
use app\models\search\LeaveRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\helpers\Configuration;

/**
 * LeaveRequestController implements the CRUD actions for LeaveRequest model.
 */
class LeaveRequestController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all LeaveRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeaveRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 

    /**
     * Displays a single Employee model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionApprove($id)
    {    
        $model = LeaveRequest::find()->where(['id' => $id, 'status' => Configuration::PENDING])->one();
        if(!$model)
        {    
            \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'This request is already approved')); 
            return $this->redirect(['index']);   
        } 
        if($this->changeStatus($id, Configuration::APPROVED))
        { 
           \Yii::$app->getSession()->setFlash('success', yii::t('app', 'Status approved successfully')); 
        } 
        else
        {
            \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'Email not send'));
        }   
        return $this->redirect(['index']);      
    }
    public function actionDecline($id)
    {    
        $model = LeaveRequest::find()->where(['id' => $id, 'status' => Configuration::PENDING])->one();
        if(!$model)
        {    
            \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'This request is already approved')); 
            return $this->redirect(['index']);   
        } 
        if($this->changeStatus($id, Configuration::DECLINED))
        { 
           \Yii::$app->getSession()->setFlash('success', yii::t('app', 'Status declined successfully')); 
        } 
        else
        {
            \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'Email not send'));
        }   
        return $this->redirect(['index']);      
    }
 

    protected function changeStatus($id, $status)
    {
        $model = LeaveRequest::findOne($id);
        $email = $model->email; 
        $model->status = $status;
        $model->verified_by = Yii::$app->user->identity->id;
        $model->verified_on = date("Y-m-d H:i:s");
        $model->save(); 
        return $this->sendMail($email,Configuration::getStatus($status));  
    }


    protected function sendMail($email, $status)
    {
        $setSubject = "Leave status updated";
        $setHtmlBody = "Your leave application has been ".$status." by admin.";
        return \app\helpers\Send_email::send($email, $setSubject, $setHtmlBody);  
        
    }
 

    /**
     * Finds the LeaveRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeaveRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeaveRequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
