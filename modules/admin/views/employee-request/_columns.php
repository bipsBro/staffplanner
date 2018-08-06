<?php
use yii\helpers\Url;
use kartik\grid\GridView; 
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=> Yii::t('app','Schedule'),
        'value' => function($model) { return $model->schedule->date.' [ '.$model->schedule->start_time.' - '.$model->schedule->end_time.')'; }
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=> Yii::t('app','Truck'),
        'value' => function($model) { return $model->schedule->truck->truck_no; }
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=> Yii::t('app','Location'),
        'value' => function($model) { return $model->schedule->location->name; }
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=> Yii::t('app','Employee'),
        'value' => function($model) { return $model->emp->getName(); }
    ],   
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=> Yii::t('app','Remaining hour'),
        'value' => function($model) { return $model->emp->hourRemaining; }
    ],  
    [
        'attribute' => 'request_type',
        'value' => function($model) {  return \app\helpers\Configuration::getStatus($model->request_type); },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => \app\helpers\Configuration::REQUEST_TYPE_ARRAY,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Request type'],
        'format' => 'raw'
    ],
    [
        'attribute' => 'status',
        'value' => function($model) {  return \app\helpers\Configuration::getStatus($model->status); },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => \app\helpers\Configuration::WORK_SCHEDULE_ARRAY,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'status'],
        'format' => 'raw'
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view} {approve} {decline}',
        'buttons' => [
                'approve' => function($url, $model, $key){
                    if($model->status == \app\helpers\Configuration::PENDING)
                    { 
                        return Html::a('<i class="fa fa-check"></i>', ['/admin/employee-work-schedule/approve', 'id' => $model->id], [
                            'title' => Yii::t('user', 'Approve this request'),
                            'data-confirm' => Yii::t('user', 'Are you sure you want to approve this request?'),
                            'data-method' => 'POST',
                        ]);
                    } 
                },
                'decline' => function($url, $model, $key){
                    if($model->status == \app\helpers\Configuration::PENDING)
                    { 
                        return Html::a('<i class="fa fa-close"></i>', ['/admin/employee-work-schedule/decline', 'id' => $model->id], [
                            'title' => Yii::t('user', 'Approve this request'),
                            'data-confirm' => Yii::t('user', 'Are you sure you want to decline this request?'),
                            'data-method' => 'POST',
                        ]);
                    } 
                }
            ],
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to(['/admin/employee-work-schedule/'.$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   