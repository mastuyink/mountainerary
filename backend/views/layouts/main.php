<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
\app\assets\MaterialAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

 <div class="container">
    <div class="row">
        <div class="wrapper active">
            <div class="side-bar">
                <ul>
                    <li class="menu-head">
                        <?= Html::a('MOUNTAINERARY', Yii::$app->homeUrl); ?> <a href="#" class="push_menu"><span class="glyphicon glyphicon-align-justify pull-right"></span></a>
                    </li>
                    <div class="menu">
                        <li>
                            <?= Html::a('Booking <span class="fa fa-book pull-right">',['/booking'],[
                                'data-toggle'    =>'tooltip',
                                'title'          =>'Booking',
                                'data-placement' =>'right'
                            ]); ?>
                        </li>
                        <li>
                            <?= Html::a('Trip <span class="fa fa-map-marker pull-right">',['/trip'],[
                                'data-toggle'    =>'tooltip',
                                'title'          =>'Trip',
                                'data-placement' =>'right'
                            ]); ?>
                        </li>
                        <li>
                            <?= Html::a('Pages <span class="fa fa-clone pull-right">',['/pages'],[
                                'data-toggle'    =>'tooltip',
                                'title'          =>'Pages',
                                'data-placement' =>'right'
                            ]); ?>
                        </li>
                        <li>
                            <?= Html::a('Category <span class="fa fa-refresh pull-right">',['/category'],[
                                'data-toggle'    =>'tooltip',
                                'title'          =>'Category',
                                'data-placement' =>'right'
                            ]); ?>
                        </li>
                        <li>
                            <?= Html::a('Shuttle <span class="fa fa-car pull-right">',['/shuttle-area'],[
                                'data-toggle'    =>'tooltip',
                                'title'          =>'Shuttle Area',
                                'data-placement' =>'right'
                            ]); ?>
                        </li>
                    </div>
                    
                </ul>
            </div>   
            <div class="content">
                <div class="col-md-12" style="margin-top: 15px;">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs('
$.material.init();
$(".push_menu").click(function(){
         $(".wrapper").toggleClass("active");
    });
$("[data-toggle=\'tooltip\']").tooltip(); 

    ', \yii\web\View::POS_READY);
 ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
