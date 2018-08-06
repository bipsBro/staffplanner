<?php

use yii\helpers\Html; 
use yii\widgets\Pjax;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LeaveRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Leave Requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="leave-request-index">
                 
                    <?php Pjax::begin(); ?> 

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
 
                             [ 
                                'attribute' => 'emp_id',
                                'value' => function($model) { return $model->employeeCode; }, 
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Employee::find()->all(),'id','employeeSelectData'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select employee...'],
                                'format' => 'raw',
                            ],  
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'leave_date', 
                                'filterType' => GridView::FILTER_DATE, 
                                'filterWidgetOptions' => [
                                    'type' => DatePicker::TYPE_INPUT,
                                    'pluginOptions' => [
                                        'format' => 'yyyy-m-dd',
                                        'allowClear' => true,  
                                        'autoclose'=>true
                                    ],
                                ], 
                                'filterInputOptions' => ['placeholder' => 'Leave date'],
                                'format' => 'raw'
                            ], 
                            'message:html',
                            'requested_date', 
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'label'=> Yii::t('app','Verified by'),
                                'value' => function($model) { return $model->verifiedByName; }
                            ],
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'verified_on',
                                'value' => function($model) { return $model->verifiedOn; }
                            ], 
                            [
                                'attribute' => 'status',
                                'value' => function($model) {  return \app\helpers\Configuration::getStatus($model->status); },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \app\helpers\Configuration::LEAVE_ARRAY,
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'status'],
                                'format' => 'raw'
                            ],

                            [ 
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {approve} {decline}',
                                'buttons' => [
                                    'approve' => function($url, $model, $key){
                                        if($model->status == \app\helpers\Configuration::PENDING)
                                        { 
                                            return Html::a('<i class="fa fa-check"></i>', ['/admin/leave-request/approve', 'id' => $model->id], [
                                                'title' => Yii::t('user', 'Approve this request'),
                                                'data-confirm' => Yii::t('user', 'Are you sure you want to approve this request?'),
                                                'data-method' => 'POST',
                                            ]);
                                        } 
                                    },
                                    'decline' => function($url, $model, $key){
                                        if($model->status == \app\helpers\Configuration::PENDING)
                                        { 
                                            return Html::a('<i class="fa fa-close"></i>', ['/admin/leave-request/decline', 'id' => $model->id], [
                                                'title' => Yii::t('user', 'Approve this request'),
                                                'data-confirm' => Yii::t('user', 'Are you sure you want to decline this request?'),
                                                'data-method' => 'POST',
                                            ]);
                                        } 
                                    }
                                ]
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 

