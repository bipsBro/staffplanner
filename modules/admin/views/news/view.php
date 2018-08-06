<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */
$this->title = Yii::t('app', 'View news');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="box"> 
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                 <p> 
                        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <div class="news-view">
                     
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [ 
                                'title',
                                'description:html',
                                'likes',
                                'expired_date',
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
</div> 
