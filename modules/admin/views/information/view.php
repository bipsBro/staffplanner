<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Information */
?>
<div class="information-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            'slug',
            'title',
            [
                'attribute' => 'show_in_menu',
                'value' => function($model){ return \app\helpers\Configuration::getStatus($model->show_in_menu); }
            ],
            [
                'attribute' => 'status',
                'value' => function($model){ return \app\helpers\Configuration::getStatus($model->status); }
            ],  
            'position',
            [
                'class'=> '\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Created at'),
                'value' => function($model) { return $model->createdDate; }
            ],   
            [
                'class'=> '\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Created by'),
                'format' => 'html',
                'value' => function($model) { return $model->createdByName; }
            ], 
            [
                'class'=> '\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Last updated at'),
                'value' => function($model) { return $model->updatedDate; }
            ],  
            [
                'class'=> '\kartik\grid\DataColumn',
                'label'=> Yii::t('app','Last updated by'),
                'format' => 'html',
                'value' => function($model) { return $model->updatedByName; }
            ], 
            'description:html',
        ],
    ]) ?>

</div>
