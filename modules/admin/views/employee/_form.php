<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker; 

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="employee-form">
            <?php $form = ActiveForm::begin(); ?>
                <div class="col-sm-12 col-md-6">



                    <?= $form->field($model, 'name')->textInput() ?>
<?php if($model->isNewRecord){ ?>
                    <?= $form->field($model, 'email')->textInput() ?>

                    <?= $form->field($model, 'username')->textInput() ?>
<?php } else { ?>
                    <?= $form->field($model, 'email')->textInput(['disabled' => 'true']) ?>

                    <?= $form->field($model, 'username')->textInput(['disabled' => 'true']) ?>
<?php } ?>                    

                    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'gender')->radioList( ['male'=>'Male', 'female' => 'Female'] ) ?> 

                    <?= $form->field($model, 'address1')->textarea(['rows' => 3]) ?>  

                </div> 
                <div class="col-sm-12 col-md-6">  
 

                    <?= $form->field($model, 'address2')->textarea(['rows' => 3]) ?> 

                    <?= $form->field($model, 'contract_limit')->textInput() ?>
 
                    <?php echo $form->field($model, 'contract_expirydate')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Enter expire date ...'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                             'format' => 'yyyy-mm-dd'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'hour_worked')->textInput() ?> 

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>


                </div>

            <?php ActiveForm::end(); ?>    
            </div>
        </div>
    </div>
</div> 
