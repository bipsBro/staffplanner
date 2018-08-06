<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserLoginLocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Login Locations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="user-login-location-index">
                 
                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?> 

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'], 

                            [
                               'attribute' => 'user_id',
                               'value' => function($model) { return $model->user->email; }
                            ],
                            'location',
                            'login_date',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '',
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div> 
