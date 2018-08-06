<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WorkSchedule */

$this->title = Yii::t('app','Schedule details : ').$model->date. ' ( '.$model->start_time. ' - '.$model->end_time.' )';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Work Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12 col-md-3">
        <div class="box"> 
            <div class="box-body">
                    <div class="work-schedule-view">
                     

                        <p>
                            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </p>

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [ 
                                'date',
                                'start_time',
                                'end_time',
                                [ 
                                    'attribute' => 'truck_id',
                                    'value' => function($model) { return $model->truck->truck_no; } 
                                ], 
                                [ 
                                    'attribute' => 'location_id',
                                    'value' => function($model) { return $model->location->name; } 
                                ],   
                                'remark:html',
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label'=> Yii::t('app','Created by'),
                                    'value' => function($model) { return $model->createdByName; }
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'created_on',
                                    'value' => function($model) { return $model->createdOn; }
                                ], 
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'label'=> Yii::t('app','Updated by'),
                                    'value' => function($model) { return $model->updatedByName; }
                                ],
                                [
                                    'class'=>'\kartik\grid\DataColumn',
                                    'attribute'=>'updated_on',
                                    'value' => function($model) { return $model->updatedOn; }
                                ], 
                            ],
                        ]) ?>

                    </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-9">
        <div class="box"> 
            <div class="box-body">
                    <div class="work-schedule-view"> 
                        <?php
                       $searchModel = new \app\models\search\EmployeeWorkScheduleSearch();
                       $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
                       $dataProvider->query->andFilterWhere(['schedule_id'=>$model->id]);
                       echo Yii::$app->controller->renderPartial('/employee-work-schedule/index',[
                           'searchModel' => $searchModel,
                           'dataProvider' => $dataProvider,
                           'model'=>$model,
                           'render'=>1
                       ])

                       ?>
                    </div>
            </div>
        </div>
    </div>
</div>

