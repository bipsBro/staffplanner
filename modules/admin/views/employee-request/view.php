<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeWorkSchedule */
?>
<div class="employee-work-schedule-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            [
                'class'=>'\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Employee'),
                'value' => function($model) { return $model->emp->getName(); }
            ], 
            [
                'class'=>'\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Employee code'),
                'value' => function($model) { return $model->emp->emp_code; }
            ], 
            [
                'class'=>'\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Hours worked'),
                'value' => function($model) { return $model->emp->hourWorked; }
            ], 
            [
                'class'=>'\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Contract limit'),
                'value' => function($model) { return $model->emp->contractLimit; }
            ], 
            [
                'attribute' => 'request_type',
                'value' => function($model) {  return \app\helpers\Configuration::getStatus($model->request_type); } 
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {  return \app\helpers\Configuration::getStatus($model->status); } 
            ],
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
