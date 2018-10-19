<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\components\EmailWidget;

$this->title = $product['name'];
$this->params['breadcrumbs'][] = ['label' => 'All Package', 'url' => ['/package']];
$this->params['breadcrumbs'][] = ['label' => $product['idCategory']['category'], 'url' => ['/package/'.$product['idCategory']['slug']]];
$this->params['breadcrumbs'][] = $this->title;
app\assets\DatePickerAsset::register($this);

$this->registerMetaTag([
    'name'    => 'description',
    'content' => $product['meta_description'],
]);
$this->registerMetaTag([
    'name'    => 'keywords',
    'content' => implode(', ',ArrayHelper::map($product['usedKeywords'], 'id', 'idKeyword.keyword')),
]);
$modelBookingForm->adults = 2;
?>
<div class="row">
	<div class="material-card">
    <div class="material-card_content">
		 <div class="container-fluid">
			<div class="wrapper row">
				<div class="preview col-md-6">
					<div class="preview-pic tab-content">
                <?php foreach($product['galerys'] as $key => $galery): ?>
                  <?php $key == 0 ? $classBig = 'tab-pane active' : $classBig = 'tab-pane' ?>
                  <div class="<?= $classBig ?>"" id="galery-<?= $galery['id'] ?>">
                    <?= Html::img(['/image/galery','id'=>$galery['id'],['class'=>'preview-picture-big','alt' => 'img-tumbnail-big']]); ?>
                  </div>
                <?php endforeach; ?>
					</div>
					<ul class="preview-thumbnail nav nav-tabs">
              <?php foreach($product['galerys'] as $key => $galery): ?>
                  <?php $key == 0 ? $clasSmall = 'active' : $clasSmall = '' ?>
                  <li class="<?= $clasSmall ?>">
                    <?= Html::a(
                        Html::img(['/image/galery','id'=>$galery['id'],['class'=>'preview-picture-small']]), 
                      null, [
                        'data-target' => '#galery-'.$galery['id'],
                        'data-toggle'=>'tab',
                        'alt' => 'img-galery'
                      ]); ?>
                  </li>
              <?php endforeach; ?>
					</ul>
						
				</div>
				<div class="details col-md-6">
					<h3 class="product-title"><?= $product['name'] ?></h3>
					<div class="rating">
						<!-- <div class="stars">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
						</div>
						 <span class="review-no">41 Booked</span> 
						</div> -->
						<p class="product-description"><?= $product['preview'] ?></p>
            <?php
            $startPrice = round($product['price_pax_adult']/$currency['kurs'],0,PHP_ROUND_HALF_UP);
             ?>
						<h4 class="price">Start From: <span> <?= $currency['currency'].' '.number_format($startPrice,0) ?></span> /Pax</h4>

						<div class="action">
              <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data']) ?>
              <?= Html::activeHiddenInput($modelBookingForm, 'id_trip', ['value' => $product['id']]); ?>
                <div class="row">
                <div class="col-sm-6">
                  <label>Date Of Trip</label>
                  <?= Html::activeTextInput($modelBookingForm, 'trip_date', [
                    'label' => false,
                    'id'    => 'form-date',
                    'class' => 'form-control form-view-price',
                    'placeholder' => 'Select Trip Date'
                  ]); ?>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-xs-6">
                      <label class="control-label" for="drop-adults">Adults</label>
                      <?= Html::activeDropDownList($modelBookingForm, 'adults', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6'], [
                        'label' => false,
                        'class' => 'form-control form-view-price',
                        'id' => 'drop-adults',
                      ]); ?>
                    </div>
                    <div class="col-xs-6">
                      <label class="control-label" for="drop-childs">Childs</label>
                     <?= Html::activeDropDownList($modelBookingForm, 'childs', ['0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5',], [
                        'label' => false,
                        'class' => 'form-control form-view-price',
                        'id' => 'drop-childs',
                      ]); ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="align-center col-md-12" id="container-prices">
              </div>
              <div class="col-md-12 m-t-20">
                <?= Html::submitButton('Book Now', ['class' => 'btn bg-orange btn-raised btn-lg btn-block']); ?>
              </div>
              
              <?= Html::endForm() ?>
						</div>
				</div>
				</div>
			</div>
		<div class="row">
			<div class="col-md-12 content">
				<p><?= $product['content'] ?></p>
			</div>
		</div>
	</div>
</div>
</div>
</div>

<div class="row m-t-20">
  <div class="material-card">
    <div class="material-card_content">
      <?= EmailWidget::widget([
        'trip' => $product['id'],
        'returnUrl' => '/package/'.$product['idCategory']['slug'].'/'.$product['slug']
      ]); ?>
    </div>
  </div>
</div>
<?php
$this->registerJs('
$(".form-view-price").on("change",function(){
  var dateVal = $("#form-date").val();
  var adults = $("#drop-adults").val();
  var childs = $("#drop-childs").val();
  if ( dateVal != "" && adults > 0) {
    $("#container-prices").html("Please wait...<i class=\'fa fa-spin fa-refresh\'></i>")
    $.ajax({
      url: "'.Url::to(['/reservation/calc-price']).'?id_trip='.$product['id'].'",
      type: "POST",
      data: {
        trip_date : dateVal,
        adults : adults,
        childs : childs
      },
      success: function(data){
        var result = JSON.parse(data);
        $("#container-prices").html("<p><span class=\'font-bold font-18\'>"+ result.currency +" "+ result.total_price +"</span><br><span class=\'font-14\'>IDR "+ result.total_price_idr+"</span></p>");
      }
    }); 
  }
});
$("table").addClass("table table-responsive table-stripped");
$("#form-date").pickadate({
	min: +1,
	format: "ddd, dd mmm, yyyy",
	formatSubmit: "yyyy-mm-dd",
	//hiddenPrefix: "prefix__",
	//hiddenSuffix: "__suffix",
	selectYears: true,
  selectMonths: true,
	today: "",
	clear: "Clear",
	close: "OK",
	closeOnSelect: false,
	closeOnClear: false,
});
	', \yii\web\View::POS_READY);
$this->registerCss("
.content > ul > li{
    list-style-type: disc;
}
.content > ol > li {
  list-style-type:decimal;
}
#form-date{
  background-color: #fff;
}
.product-description{
  text-align:justify;
}
.nav-tabs{
  background-color: #F5F5F5;
}
.preview-picture-big{
  max-height: 100%;
  overflow: hidden;
}
.content p{
  text-align: justify;
  padding: 10px 20px;
}
/*****************globals*************/
.picker__select--month, .picker__select--year{
	padding: 0px 10px;
	font-size: 21px;
}
body {
  overflow-x: hidden; 
}

img {
  max-width: 100%; 
}

.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
  -ms-flex-positive: 1;
  flex-grow: 1;
  height: 200px;
}

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 10px; 
  height: 50px;
}
.preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%;
}
.preview-thumbnail.nav-tabs li img {
      max-width: 100%;
      display: block;
      height: 50px;
      overflow: hidden;
}
.preview-thumbnail.nav-tabs li a {
      padding: 0;
      margin: 0;
}
.preview-thumbnail.nav-tabs li:last-of-type {
      margin-right: 0;
}

.tab-content {
  overflow: hidden; }
  .tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
            animation-name: opacity;
    -webkit-animation-duration: .3s;
            animation-duration: .3s; }
@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; } }

.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }


.product-title, .price, .sizes, .colors {
  font-weight: bold; }

.checked, .price span {
  color: #ff9f1a; }

.product-title, .rating, .product-description, .price, .vote, .sizes {
  margin-bottom: 15px; }

.product-title {
  margin-top: 0; }

.size {
  margin-right: 10px; }
  .size:first-of-type {
    margin-left: 10px; }

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  height: 2em;
  width: 2em;
  border-radius: 2px; }
  .color:first-of-type {
    margin-left: 20px; }

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3);
    }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1);
    } 
}
	");
 ?>