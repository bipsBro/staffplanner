<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker; 
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\WorkSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="work-schedule-form">
            <?php $form = ActiveForm::begin(); ?> 
                <div class="col-sm-12 col-md-6"> 
 
                        <?php echo $form->field($model, 'date')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Enter date ...'],
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]); ?>

                        <?php echo $form->field($model, 'start_time')->widget(TimePicker::classname(), [
                        'options' => ['placeholder' => 'Enter start date ...'],
                            'pluginOptions' => [
                                "showMeridian" => false,
                            ]
                        ]); ?>

                        <?php echo $form->field($model, 'end_time')->widget(TimePicker::classname(), [
                            'options' => ['placeholder' => 'Enter end date ...'],
                                'pluginOptions' => [
                                    "showMeridian" => false,
                                ]
                        ]); ?>
 


                        <?php  
                        if($model->isNewRecord){
                            // Tagging support Multiple 
                            echo $form->field($model, 'empID')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(\app\models\Employee::find()->all(), 'id', 'employeeSelectDataSchedule'),
                                'size' => Select2::MEDIUM,
                                'options' => ['placeholder' => Yii::t('app', 'Select employee').' ...', 'multiple' => true],
                                'pluginOptions' => [ 
                                    'allowClear' => true, 
                                ],
                            ]);
                        }
                         ?> 
                </div>
                <div class="col-sm-12 col-md-6">  

                        <?php
                            echo $form->field($model, 'truck_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(\app\models\Truck::find()->all(), 'id', 'truck_no'),
                                'options' => ['placeholder' => 'Select truck number'],
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
 

                        <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?> 

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                            <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                        </div>  
                </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div> 
