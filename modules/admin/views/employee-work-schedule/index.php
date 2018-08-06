<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\web\NotFoundHttpException;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EmployeeWorkScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if(!isset($model->id)){ throw new NotFoundHttpException('The requested page does not exist.'); }

$this->title = Yii::t('app', 'Employee Work Schedules');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="employee-work-schedule-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    (date("Y-m-d") <= $model->date) ? Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/admin/employee-work-schedule/create?id='.$model->id],
                    ['role'=>'modal-remote','title'=> 'Create new Employee Work Schedules','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['/admin/work-schedule/view?id='.$model->id],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}' :
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['/admin/work-schedule/view?id='.$model->id],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'

                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Employee Work Schedules listing', 
            
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
