<?php

use yii\helpers\Html; 
use yii\widgets\Pjax;
use kartik\date\DatePicker; 
use kartik\grid\GridView; 
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Employees');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="employee-index">
                 
                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('<i class="fa fa-plus-circle"></i> '. Yii::t('app', 'Create Employee'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],  
                            [
                                'attribute' => 'name',
                                'value' => function($model) { return $model->emp_code.' - '.$model->getName(); } 
                            ],
                            [
                                'attribute' => 'email',
                                'value' => function($model) { return $model->getEmail(); }
                            ], 
                            [
                                'attribute' => 'username',
                                'value' => function($model) { return $model->getUserName(); }
                            ], 
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'label'=> Yii::t('app','Hour worked / Contract limit'),
                                'value' => function($model) { return $model->hourWorked.' / '.$model->contractLimit; }
                            ],
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'contract_expirydate', 
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
                                'header' => Yii::t('user', 'Confirmation'),
                                'value' => function ($model) {
                                    if ($model->userData->isConfirmed) {
                                        return '<div class="text-center">
                                                    <span class="text-success">' . Yii::t('user', 'Confirmed') . '</span>
                                                </div>';
                                    } else {
                                        return Html::a(Yii::t('user', 'Confirm'), ['/admin/user-action/confirm', 'id' => $model->userData->id], [
                                            'class' => 'btn btn-xs btn-success btn-block',
                                            'data-method' => 'post',
                                            'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                                        ]);
                                    }
                                },
                                'format' => 'raw',
                                'visible' => Yii::$app->getModule('user')->enableConfirmation,
                            ],
                            [
                                'header' => Yii::t('user', 'Block status'),
                                'value' => function ($model) {
                                    if ($model->userData->isBlocked) {
                                        return Html::a(Yii::t('user', 'Unblock'), ['/admin/user-action/block', 'id' => $model->userData->id], [
                                            'class' => 'btn btn-xs btn-success btn-block',
                                            'data-method' => 'post',
                                            'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                                        ]);
                                    } else {
                                        return Html::a(Yii::t('user', 'Block'), ['/admin/user-action/block', 'id' => $model->userData->id], [
                                            'class' => 'btn btn-xs btn-danger btn-block',
                                            'data-method' => 'post',
                                            'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                                        ]);
                                    }
                                },
                                'format' => 'raw',
                            ],


                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update} {delete} {resend_password} ',
                                'buttons' => [
                                    'resend_password' => function ($url, $model, $key) {
                                        if (\Yii::$app->user->identity->isAdmin && !$model->userData->isAdmin) {
                                            return '
                                        <a data-method="POST" data-confirm="' . Yii::t('user', 'Are you sure?') . '" href="' . Url::to(['/admin/user-action/resend-password', 'id' => $model->userData->id]) . '">
                                        <span title="' . Yii::t('user', 'Generate and send new password to user') . '" class="glyphicon glyphicon-envelope">
                                        </span> </a>';
                                        }
                                    }, 
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
