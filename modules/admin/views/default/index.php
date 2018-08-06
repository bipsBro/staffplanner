<?php
$this->title ="Admin dashboard";
?>


<div class="sms-dashboard-index"> 
     <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-bus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><?= Yii::t('app','TOTAL TRUCKS') ?></span>
              <span class="info-box-number"><small><?= count(\app\models\Truck::find()->all());?></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-envelope"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><?= Yii::t('app','TOTAL EMPLOYEE') ?></span>
              <span class="info-box-number"><?= count(\app\models\Employee::find()->all());?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"><?= Yii::t('app',"LEAVE REQUEST") ?></span>
                  <span class="info-box-number"><?= count(\app\models\LeaveRequest::find()->where(["status" => \app\helpers\Configuration::PENDING])->all());?></span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          
            <div class="info-box">
              <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','USER TEACHER') ?></span>
                <span class="info-box-number"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          
        </div>
        <!-- /.col -->
    </div> 
</div>      