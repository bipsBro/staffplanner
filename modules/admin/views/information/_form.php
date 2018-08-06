<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\slider\Slider;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Information */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="information-form">

    <?php $form = ActiveForm::begin(); ?> 

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?> 

    <?php
    echo $form->field($model, 'show_in_menu')->widget(Select2::classname(), [
        'data' => \app\helpers\Configuration::FEATURE_ARRAY,
        'options' => ['placeholder' => 'Select Yes or No'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?php
    echo $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => \app\helpers\Configuration::STATUS_ARRAY,
        'options' => ['placeholder' => 'Select Active or Inactive'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>  

    <br/>
    <br/>
    <br/>
    <?= $form->field($model, 'position')->widget(Slider::classname(), [
        'sliderColor'=>Slider::TYPE_GREY,
        'handleColor'=>Slider::TYPE_DANGER,
        'pluginOptions'=>[
            'min'=>-50,
            'max'=>50,
            'step'=>1,

            'handle'=>'triangle',
            'tooltip'=>'always'

        ]
    ]); ?>

    
    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
