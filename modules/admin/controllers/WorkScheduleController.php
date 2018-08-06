<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\WorkSchedule;
use app\models\search\WorkScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\EmployeeWorkSchedule;

/**
 * WorkScheduleController implements the CRUD actions for WorkSchedule model.
 */
class WorkScheduleController extends Controller
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
     * Lists all WorkSchedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy("id DESC");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkSchedule model.
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

    /**
     * Creates a new WorkSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WorkSchedule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(!empty($model->empID))
            { 
                foreach($model->empID as $employee)
                {
                    $modelEmp = new EmployeeWorkSchedule();
                    $modelEmp->emp_id = $employee;
                    $modelEmp->schedule_id = $model->id;
                    $modelEmp->request_type  = \app\helpers\Configuration::ADMIN_CREATED;
                    $modelEmp->status = \app\helpers\Configuration::APPROVED; 
                    if($modelEmp->save())
                    {
                        $modelEmployee = \app\models\Employee::findOne($employee);
                        $modelEmployee->hour_worked = ($modelEmployee->hour_worked + $model->minutes)/60;
                        $modelEmployee->save(false);
 
                    }
                }
            }    
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WorkSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WorkSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkSchedule::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
