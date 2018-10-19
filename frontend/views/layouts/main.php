<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
//\app\assets\MaterialAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="icon" type="image/png" href="/img/pavicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= $this->render('_navbar'); ?>
<section>
<section class="services-sec">
    <div class="container">
        <div class="row font-12">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        </div>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

</section>
<?= Html::button(' Top <span></span>', [
  'class'       => 'btn btn-scroll btn-sm bg-orange',
  'id'          => 'btn-scroll',
  'data-toggle' => 'tooltip',
  'title'       => 'Back To Top',
  'href'        => 'body'
  ]); ?>
<?php 

 $this->registerJs('
//$.material.init();
$("[data-toggle=\'tooltip\']").tooltip(); 
$(window).scroll(function(){ 
    if ($(this).scrollTop() > 100) { 
        $("#btn-scroll").fadeIn(); 
    } else { 
        $("#btn-scroll").fadeOut(); 
    } 
});

$(".btn-scroll").click(function(){
    var point = $(this).attr("href");
    $("html, body").animate({
        scrollTop: $(point).offset().top -75
    }, 1000);
    return true;
});
     ', \yii\web\View::POS_READY);

$this->registerCss("
body{
  font-family: 'Nunito', sans-serif;
}
#navbar-logo{
    height: 50px;
    width: auto;
}

.navbar-brand {
    padding: 0px 5px 5px 5px;
}

.affix-top{
    background: linear-gradient(to left, #5fa8e3,#97c7e7);
}
// .affix.top-bar .navbar-nav li a {
//     color: #FFF;
// }
// .top-bar{
//     background: linear-gradient(to left, #5fa8e3,#97c7e7);
// }
.services-sec{
    padding: 50px 0 50px;
}
 #btn-scroll {
  display:none;
  position:fixed;
  right:10px;
  bottom:100px;
  cursor:pointer;
  width:50px;
  height:50px;
  text-indent:-9999px;
  display:none;
  -webkit-border-radius:60px;
  -moz-border-radius:60px;
  border-radius:60px;
  z-index: 200;
}
#btn-scroll span {
    position:absolute;
    top:50%;
    left:50%;
    margin-left:-8px;
    margin-top:-12px;
    height:0;
    width:0;
    border:8px solid transparent;
    border-bottom-color:#ffffff;
}
#btn-scroll:hover {
   // background-color:#e74c3c;
    opacity:1;filter:'alpha(opacity=100)';
    -ms-filter:'alpha(opacity=100)';
}
     ");

?>
<?= $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
