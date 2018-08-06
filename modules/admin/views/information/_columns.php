<?php
use yii\helpers\Url;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;  


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
        'attribute'=>'show_in_menu',
        'value' => function ($model) { return \app\helpers\Configuration::getStatus($model->show_in_menu);},
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => \app\helpers\Configuration::FEATURE_ARRAY,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Show in menu'],
        'format' => 'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'value' => function($model) { return \app\helpers\Configuration::getStatus($model->status); },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => \app\helpers\Configuration::STATUS_ARRAY,
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'status'],
        'format' => 'raw'
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'position',
    ],     
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
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