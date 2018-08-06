<?php

use yii\helpers\Html;
use kartik\date\DatePicker; 
use kartik\grid\GridView; 
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\WorkScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Work Schedules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="work-schedule-index">
                 
                    <?php Pjax::begin(); ?> 

                    <p>
                        <?= Html::a(Yii::t('app', 'Create Schedule'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
 
                            [
                                'class'=>'\kartik\grid\DataColumn',
                                'attribute'=>'date', 
                                'filterType' => GridView::FILTER_DATE, 
                                'filterWidgetOptions' => [
                                    'type' => DatePicker::TYPE_INPUT,
                                    'pluginOptions' => [
                                        'format' => 'yyyy-m-dd',
                                        'allowClear' => true,  
                                        'autoclose'=>true
                                    ],
                                ], 
                                'filterInputOptions' => ['placeholder' => 'Select date'],
                                'format' => 'raw'
                            ], 
                            'start_time',
                            'end_time',
                            [ 
                                'attribute' => 'truck_id',
                                'value' => function($model) { return $model->truck->truck_no; }, 
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Truck::find()->all(),'id','truck_no'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a truck ...'],
                                'format' => 'raw',
                            ], 
                            [ 
                                'attribute' => 'location_id',
                                'value' => function($model) { return $model->location->name; }, 
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Location::find()->all(),'id','name'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Select a location ...'],
                                'format' => 'raw',
                            ],   

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 
