<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LeaveRequest */

$this->title = $model->employeeCode.' - '.yii::t('app','Leave Request');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Leave Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="leave-request-view"> 
 

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [ 
                            [ 
                                'attribute' => 'emp_id',
                                'value' => function($model) { return $model->employeeCode; },  
                            ],  
                            'leave_date',
                            [
                                'attribute' => 'status',
                                'value' => function($model) {  return \app\helpers\Configuration::getStatus($model->status); } 
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
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div> 
