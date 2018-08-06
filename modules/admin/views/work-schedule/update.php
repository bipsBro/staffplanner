<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WorkSchedule */

$this->title = Yii::t('app', 'Update Work Schedule: ' . $model->date. ' ( '.$model->start_time. ' - '.$model->end_time.' )', [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Work Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->date. ' ( '.$model->start_time. ' - '.$model->end_time.' )', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="work-schedule-update">
 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
