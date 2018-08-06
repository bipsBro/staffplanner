<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WorkSchedule */

$this->title = Yii::t('app', 'Create Work Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Work Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-schedule-create">
 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
