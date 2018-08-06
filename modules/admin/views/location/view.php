<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Location */
?>
<div class="location-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            'name',
            'zipcode',
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
