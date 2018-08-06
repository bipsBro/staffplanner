<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeWorkSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-work-schedule-form">

    <?php $form = ActiveForm::begin(); ?>

   <?php
        echo $form->field($model, 'emp_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\app\models\Employee::find()->all(), 'id', 'employeeSelectDataSchedule'),
            'options' => ['placeholder' => 'Select a employee...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?> 
  

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
