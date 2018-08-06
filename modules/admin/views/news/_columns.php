<?php
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\grid\GridView; 

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
        'attribute'=>'title',
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'likes',
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'expired_date', 
        'filterType' => GridView::FILTER_DATE, 
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'format' => 'yyyy-m-dd',
                'allowClear' => true,  
                'autoclose'=>true
            ],
        ], 
        'filterInputOptions' => ['placeholder' => 'Select expire date'],
        'format' => 'raw'
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
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   