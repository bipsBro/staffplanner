<?php
use yii\helpers\Url;

?>
<aside class="main-sidebar">

    <section class="sidebar"> 
       
        <!-- /.search form -->
        
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Main navigation', 'options' => ['class' => 'header']],

                    [
                        'url' => '/admin',
                        'label' => Yii::t('app','Home'),
                        'icon' => 'home'
                    ],     
                    [
                        'url' => '/admin/information', 
                        'label' => Yii::t('app','Information'),
                        'icon' => 'info'
                    ],    
                    [
                        'url' => '/admin/truck', 
                        'label' => Yii::t('app','Truck'),
                        'icon' => 'bus'
                    ],   
                    [
                        'url' => '/admin/location', 
                        'label' => Yii::t('app','Location'),
                        'icon' => 'map-marker'
                    ],    
                    [
                        'url' => '/admin/news', 
                        'label' => Yii::t('app','News and information'),
                        'icon' => 'newspaper-o'
                    ],     
                    [
                        'url' => '/admin/employee', 
                        'label' => Yii::t('app','Employee'),
                        'icon' => 'user'
                    ],     
                    [
                        'url' => '/admin/work-schedule', 
                        'label' => Yii::t('app','Work schedule'),
                        'icon' => 'clock-o'
                    ],       
                    [
                        'url' => '/admin/employee-request', 
                        'label' => Yii::t('app','Employee request'),
                        'icon' => 'bell-o'
                    ],         
                    [
                        'url' => '/admin/leave-request', 
                        'label' => Yii::t('app','Leave request'),
                        'icon' => 'bed'
                    ],   
                    [
                        'url' => '/admin/user-login-location', 
                        'label' => Yii::t('app','User login location'),
                        'icon' => 'map-marker'
                    ],       
                    [
                        'url' => '/user/settings',
                        'label' => Yii::t('app','My Account'),
                        'icon' => 'user'
                    ],  


                ],
            ]
        ) ?>
        <?php  if(Yii::$app->user->can("developer")) { ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [ 

                     [
                        'url' => '/developer/configuration',
                        'label' => 'Configuration',
                        'icon' => 'expeditedssl'
                    ],    
                    [
                        'url' => '/rbac',
                        'label' => 'Users Management',
                        'icon' => 'users'
                    ],   
                ],
            ]
        ) ?>
        <?php } ?>

    </section>

</aside>
