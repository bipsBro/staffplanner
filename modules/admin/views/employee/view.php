<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use app\models\WorkSchedule; 
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker; 
use kartik\time\TimePicker;
use yii\widgets\ActiveForm; 
use app\models\EmployeeWorkSchedule;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = yii::t('app','Employee code').' : '.$model->emp_code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; 
$data = []; 
foreach ($empWokSchedule as $value) { 
    $data = array_merge($data, [[
        'title' => $value->schedule->start_time.'-'.$value->schedule->end_time,
        'start' => $value->schedule->date
    ]]);
} 
 
?>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="box"> 
            <div class="box-body">
                <div class="employee-view">
 

                    <p>
                        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?php echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]);
                        echo "&nbsp;&nbsp;";
                         if (\Yii::$app->user->identity->isAdmin && !$model->userData->isAdmin) {
                            echo '
                        <a data-method="POST" class = "btn btn-info" data-confirm="' . Yii::t('user', 'Are you sure?') . '" href="' . Url::to(['/admin/user-action/resend-password', 'id' => $model->userData->id]) . '">
                        <span title="' . Yii::t('user', 'Generate and send new password to user') . '" class="glyphicon glyphicon-envelope">
                        </span> ' . Yii::t('user', 'Generate password') . '</a>&nbsp;&nbsp;';
                        }

                         if ($model->userData->isBlocked) {
                            echo Html::a(Yii::t('user', 'Unblock'), ['/admin/user-action/block', 'id' => $model->userData->id], [
                                'class' => 'btn btn-success',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                            ]);
                        } else {
                            echo Html::a(Yii::t('user', 'Block'), ['/admin/user-action/block', 'id' => $model->userData->id], [
                                'class' => 'btn btn-danger',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                            ]);
                        }
                        echo "<br/>";
                        if ($model->userData->isConfirmed) {
                            echo '<b>Account confirmation : </b><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span> ';
                        } else {
                            echo Html::a(Yii::t('user', 'Confirm'), ['/admin/user-action/confirm', 'id' => $model->userData->id], [
                                'class' => 'btn btn-xs btn-success btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                            ]);
                        }

                     ?>

                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [  
                            'emp_code',
                            [
                                'label' => yii::t('app','Name'),
                                'value' => function($model) { return $model->getName(); }
                            ],
                            [
                                'label' => yii::t('app','Email'),
                                'value' => function($model) { return $model->getEmail(); }
                            ], 
                            [
                                'attribute' => 'username',
                                'value' => function($model) { return $model->getUserName(); }
                            ], 
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=> 'gender',
                                'value' => function($model) { return $model->user->gender; }
                            ],
                            'contact_no',
                            'address1:ntext',
                            'address2:ntext',
                            'contract_url:url',
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=> 'contract_limit',
                                'value' => function($model) { return $model->contractLimit; }
                            ],
                            'contract_expirydate',
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=> 'hour_worked',
                                'value' => function($model) { return $model->hourWorked; }
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
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="box"> 
            <div class="box-header">   
                <h3><?= Yii::t('app', 'Assign work schedule'); ?></h3>
            </div>
            <div class="box-body">   
                <div id="calendar"> </div> 
            </div>
        </div>
    </div> 
</div> 

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Assign schedule</h4>
        </div>
        <div class="modal-body">
            <?php 
                $model = new WorkSchedule();
                $form = ActiveForm::begin(); 
            ?>
                    <?php
                    echo $form->field($model, 'truck_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\Truck::find()->all(), 'id', 'truck_no'),
                        'options' => ['placeholder' => 'Select truck'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                    <?php
                    echo $form->field($model, 'location_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\Location::find()->all(), 'id', 'name'),
                        'options' => ['placeholder' => 'Select location'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?> 

                    <?= $form->field($model, 'remark')->textarea(['rows' => 2]) ?>  

                    <?php echo $form->field($model, 'start_time')->widget(TimePicker::classname(), [
                        'options' => ['placeholder' => 'Enter start date ...'],
                            'pluginOptions' => [
                                'showSeconds' => true
                            ]
                    ]); ?>

                    <?php echo $form->field($model, 'end_time')->widget(TimePicker::classname(), [
                        'options' => ['placeholder' => 'Enter end date ...'],
                            'pluginOptions' => [
                                'showSeconds' => true
                            ]
                    ]); ?>
 
 

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                    </div> 
            <?php ActiveForm::end(); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<?php  
//$rss = (object) array('data'=>$data);
$json = json_encode($data); 
$script = <<< JS
 
 $('#calendar').fullCalendar({
    events: $json,
    /*[ 
        {
          title: 'My Event',
          start: '2018-07-20', 
        },
        {
          title: 'My Event1',
          start: '2018-07-20', 
        },
        {
          title: 'Saturday off',
          start: '2018-07-21', 
        }
        // other events here
    ],*/
  
    // dayClick: function(date, jsEvent, view) {
    //     $("#myModal").modal("show");
    // },
    

    selectable: true,
    selectConstraint: {
        start: $.fullCalendar.moment().subtract(1, 'days'),
        end: $.fullCalendar.moment().startOf('month').add(1, 'month')
    } 

  })

JS;

$this->registerJs($script);

?>
