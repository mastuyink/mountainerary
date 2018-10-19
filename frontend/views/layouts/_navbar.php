
<?php
use yii\helpers\Html;
use yii\helpers\Url;
$currencyList = Yii::$app->params['currencyList'];

$session = Yii::$app->session;
if ($session['currency'] == NULL) {
  $currentCurrency = 'USD';
}else{
  $currentCurrency = $session['currency'];
}
?>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top top-bar"  data-offset-top="200" data-spy="affix" >
    <div class="container">
      <div class="row m-b-10 font-12">
        <div class="col-md-6 col-xs-5"> <?= Html::a('<span class="fa fa-whatsapp"></span> +6281382595239', 'https://api.whatsapp.com/send?phone=6281382595239',['class'=>'pull-right']); ?></div>
        <div class="col-md-6 col-xs-7"> <?= Html::a('<span class="fa fa-envelope"></span>mountaineray@gmail.com', 'mailto:+mountaineray@gmail.com',['class'=>'pull-left']); ?></div>
      </div>
    <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="<?= Yii::$app->homeUrl ?>" class="navbar-brand"><img id="navbar-logo" alt="logo-navbar" src="/img/logo.png"></a>
      </div>
      <div class="navbar-collapse collapse" id="navbar">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="/package/mount-bromo">Mount Bromo</a></li>
            <li><a href="/package/mount-ijen">Mount Ijen</a></li>
            <li><a href="/package/mount-bromo-and-mount-ijen-blue-fire">Mount Bromo & Ijen</a></li>
            <li><a href="/package/mount-batur">Mount Batur</a></li>
            <li><a href="/contact-us">Contact</a></li>
            <li><a href="/about-us">About</a></li>
            <li class="dropdown">
              <?= Html::a('<span id="currency-display">'.$currentCurrency.'</span><span class="caret"></span>', NULL, [
                'class'         => 'dropdown-toggle',
                'data-toggle'   => 'dropdown',
                'role'          => 'button',
                'aria-haspopup' => 'true',
                'aria-expanded' => false
              ]); ?>
              <ul class="dropdown-menu">
                <?php foreach ($currencyList as $value => $text): ?>
                  <li>
                    <?= Html::a($text, NULL, ['value' => $value,'text'=>$text,'class' => 'dropdown-select-currency']); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>
<?php

$this->registerCss('
.dropdown-select-currency{
  color: #5fa8e3 !important;
}
');
$this->registerJs('
$(".dropdown-select-currency").on("click",function(){
  $("#currency-display").html("<i class=\'fa fa-spin fa-refresh\'></i>");
  $.ajax({
    url: "'.Url::to(['/reservation/change-currency']).'",
    type: "POST",
    data: {
      currency: $(this).attr("value")
    },
    success: function(){
      location.reload();
    },
    error: function(){
      alert("failed to Change Currency, Please Try Again");
    }
  })
});
  ', \yii\web\View::POS_READY);
 ?>