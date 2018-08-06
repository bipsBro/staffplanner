<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Employee;
use app\models\search\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use dektrium\user\models\User;
use app\models\Profile;
use app\models\EmployeeWorkSchedule;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {   
        
        $searchModel = new EmployeeSearch();
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
        $empWokSchedule = EmployeeWorkSchedule::find()->where(['emp_id' =>$id])->andWhere(['status' => \app\helpers\Configuration::APPROVED])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'empWokSchedule' => $empWokSchedule,
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();
        $model->scenario = $model::SCENARIO_CREATE; 

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/
        if ($model->load(Yii::$app->request->post())) {
            if(self::checkUserEmail($model))
            {
                \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'This email already exist. Please try with another email....'));
            } elseif(self::checkUserName($model)) {
                \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'This username already exist. Please try with another username....'));
            } else {
                self::createUser($model);
                if($model->userId)
                {
                    $model->user_id = $model->userId;
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function checkUserEmail($model)
    {
        $email = $model->email;
        $checkEmail = User::find()->where(['email' => $email])->one();
        if($checkEmail)
        {
            return true;
        }
        return false;
    }
    public function checkUserName($model)
    {
        $username = $model->username;
        $checkUserName = User::find()->where(['username' => $username])->one();
        if($checkUserName)
        {
            return true;
        }
        return false;
    }

    public function createUser(&$model)
    {
        $user = new User();
        $email  = $model->email;
        $username = $model->username; 
        $password=uniqid();

        $user->setAttributes(
            [
                'email' => $email,
                'username' =>$username,
                'password' => $password,
            ]

        );

        $user->password_hash = Yii::$app->security
                    ->generatePasswordHash(
                        $password, 
                        Yii::$app->getModule('user')->cost
                    );

        $profile = \Yii::createObject(Profile::className());
        $profile->setAttributes([
            'name' => $model->name,
            'public_email' => $model->email, 
            'gender' => $model->gender,
        ]);

        $user->setProfile($profile);  
         

        if ( $user->register()) {
            $userId = $user->id;
            $model->userId = $userId;
            $auth = \Yii::$app->authManager;
            $employeeRole = $auth->getRole(\app\helpers\Configuration::USER_ROLE_EMPLOYEE);
            if($employeeRole){
                try
                {
                    $auth->assign($employeeRole, $userId); 
                }
                catch(\yii\db\Exception $exception){
                    \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'User role is already assigned....')); 
                } 
            }
            $email = $model->email;
           /* if(self::sendUserMail($email, $user, $password)){
                return true;
            }*/ 
            return true;
        }
        \Yii::$app->getSession()->setFlash('warning', yii::t('app', 'There is some error on creating user'));
        return false;          
    }

   /* private function sendUserMail($email, $user, $password){

        return Yii::$app->mailer->compose('@app/mail/booking/registration', ['user'=>$user, 'password' => $password])
            ->setTo($email)
            ->setBcc(Yii::$app->params['adminEmail'])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('Your booking request has been conformed')
            // ->setHtmlBody("asdfadsf")
            ->send();
    }*/

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setUserInfo();
        $model->scenario = $model::SCENARIO_UPDATE;  

        if ($model->load(Yii::$app->request->post()) && $model->save()) {  
            $modelProfile=Profile::findOne(['user_id' => $model->userId]);
            $modelProfile->name = $model->name;
            $modelProfile->gender = $model->gender;
            $modelProfile->save();
           /* var_dump($model); echo "<hr/>"; var_dump($modelProfile->attributes); var_dump($modelProfile->errors); die(); */  
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Employee model.
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
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
