<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = $listProduct[0]['idCategory']['category'];
$this->params['breadcrumbs'][] = ['label' => 'All Package', 'url' => ['/package']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name'    => 'description',
    'content' => $listProduct[0]['meta_description'],
]);
$this->registerMetaTag([
    'name'    => 'keywords',
    'content' => implode(', ',ArrayHelper::map($listProduct[0]['usedKeywords'], 'id', 'idKeyword.keyword')),
]);
?>
<div class="row">
    <div class="col-md-12">
    <div class="material-card">
        <div class="material-card_content">
        <h1 class="font-24 font-bold align-center"><?= Html::encode($this->title); ?></h1>
        <p class="font-18 align-center"><?= Html::encode($listProduct[0]['meta_description']); ?></p>
        </div>
    </div>
    </div>
</div>

 <div id="product-overview" class="row m-t-20">
    <div id="product-overview" class="row">
        <div class="col-md-12">
        <?php foreach ($listProduct as $key => $product): ?>
      <?php
      $startPrice = round($product['price_pax_adult']/$currency['kurs'],0,PHP_ROUND_HALF_UP);
       ?>
        <div class="col-sm-6 col-md-4 col-xs-12">
            <div class="thumbnail material-card material-card-h-350">
                <div class="material-card_header">
                    <?= Html::a(Html::img(['/image/thumbnail','slug'=>$product['slug']], ['class' => 'material-card_img','alt'=>'thumbnail-'.$product['name']]), '/package/'.$product['idCategory']['slug'].'/'.$product['slug'], [
                      'class' => 'img-link',
                      'alt' => 'img-tumbnail-home'
                    ]); ?>
                </div>
                <div class="material-card_content">
                    <h3 class="material-card_title"><?= $product['name'] ?></h3>
                    
                </div>
                <footer class="material-card_footer">
                    <span class="pull-left price font-bold">Start From <?= $currency['currency'].' '.number_format($startPrice,0) ?> / pax</span>
                    <?= Html::a('Book Now', ['/package/'.$product['idCategory']['slug'].'/'.$product['slug']], ['class' => 'btn btn-transparent']); ?>
                </footer>
            </div>
        </div>
    <?php endforeach; ?>
        </div>
    </div>
</div>
<?php 
$this->registerCss("
.jumbotron h1{
    font-size:24px;
    font-weight:bold;
}
.jumbotron p {
    font-size: 18px;
}

");
?>