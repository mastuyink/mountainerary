<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;
$this->title = $homePage['title'];
$this->registerMetaTag([
    'name'    => 'description',
    'content' => $homePage['meta_description'],
]);
$this->registerMetaTag([
    'name'    => 'keywords',
    'content' => implode(', ',ArrayHelper::map($homePage['usedKeywords'], 'id', 'idKeyword.keyword')),
]);

$adultList = ['1'=>'1','2'=>'2','3'=>'3','4'=>'4'];
$childList = ['0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4'];

app\assets\DatePickerAsset::register($this);
?>
<section class="cover">
    <div class="container">
                  <div class="row">
                    <div class="col-md-6 col-sm-12 col-md-offset-1">
                          <div class="text-block">
                            <?= $homePage['content'] ?>
                              <!-- <div class="action-bar">
                                <a class="btn btn-transparent font-bold"></i>Book Now</a>
                              </div> -->
                        </div>
                        <div class="col-md-3 col-sm-12 col-md-offset-1">
                            <div class="img-block">
                              <!-- <img class="img-responsive" src="img/head.png" > -->
                            </div>
                        </div>
                  </div>
    </div>
</section>
<section class="services-sec" id="services">
  <div class="container">
    <div class="row">
      <div class="material-card m-l-15 m-r-15 m-b-10">
        <div class="material-card_content">
          <h2 class="text-center font-bold font-24">Book Your Trip</h2>
          <div class="row">
            <?= \common\widgets\Alert::widget() ?>
            <?= Html::beginForm('/reservation/book-now', 'post', ['enctype' => 'multipart/form-data']) ?>
          <div class="col-md-4">
            <label>Trip</label>
            <?= Html::dropDownList('BookingForm[id_trip]', $selection = null, $listTripDropDown, [
              'class' => 'form-view-price form-control',
              'id' => 'drop-trips',
            ]); ?>
          </div>
          <div class="col-md-2">
            <label>Trip Date</label>
            <?= Html::textInput('BookingForm[trip_date]', $value = null, [
              'placeholder' => 'Select Date',
              'id' => 'form-date',
              'class'=>'form-view-price form-control'
            ]); ?>
          </div>
          <div class="col-md-1 col-xs-6">
            <label>Adult</label>
            <?= Html::dropDownList('BookingForm[adults]', 2, $adultList , [
              'class' => 'form-view-price form-control',
              'id' => 'drop-adults',
            ]); ?>
          </div>
          <div class="col-md-1 col-xs-6">
            <label>Child</label>
            <?= Html::dropDownList('BookingForm[childs]', $selection = null, $childList , [
              'class' => 'form-view-price form-control',
              'id' => 'drop-childs',
            ]); ?>
          </div>
          <div class="col-md-4 col-xs-12">
            <div class="align-center col-md-12" id="container-prices">&nbsp</div>
            <?= Html::submitButton('Book Now', ['class' => 'btn btn-lg btn-block bg-orange']); ?>
          </div>
          <?= Html::endForm() ?>
          </div>
        </div>
    </div>
  </div>
    <div class="material-card">
    <div class="material-card_content">
    <h2 class="text-center font-bold">Plan Your Itinerary</h2>
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="service-block text-center">
          <i class="fa fa-usd" aria-hidden="true"></i>
          <h3>Affordable Price</h3>
          <p>Start your adventure with affordable rate covered all inclusions needed.</p>
          
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="service-block text-center">
          <i class="fa fa-money" aria-hidden="true"></i>
          <h3>Easy and Secured Payment Method</h3>
          <p>Pay by using credit card through PayPal or pay it after the trip end</p>
          
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="service-block text-center">
          <i class="fa fa-suitcase" aria-hidden="true"></i>
          <h3>The Organizer</h3>
          <p>Hassle free, We organize and prepare everything for your trip</p>
          
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="service-block text-center">
          <i class="fa fa-wechat" aria-hidden="true"></i>
          <h3>Discuss your itinerary</h3>
          <p>Contact us via email or whatsapp to discuss your planning. 24/7 Service</p>
          
        </div>
    </div>
    </div>
</div>
</div>
  </div>
        
</section>
        
<section class="services-sec" id="services">
        
  <div class="container">
    <h2 class="text-center font-bold">Most Popular Trips</h2>
    <?php foreach ($listProduct as $key => $product): ?>
      <?php
      $startPrice = round($product['price_pax_adult']/$currency['kurs'],0,PHP_ROUND_HALF_UP);
       ?>
        <div class="col-sm-6 col-md-4 col-xs-12">
            <div class="thumbnail material-card material-card-h-350">
                <div class="material-card_header">
                    <?= Html::a(Html::img(['/image/thumbnail','slug'=>$product['slug']], ['class' => 'material-card_img','alt'=>'thumbnail-'.$product['name']]), '/package/'.$product['idCategory']['slug'].'/'.$product['slug'], [
                      //'class' => 'material-card_header_img',
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
</section>
<?php
$this->registerJs('
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
$(".form-view-price").on("change",function(){
  var dateVal = $("#form-date").val();
  var adults = $("#drop-adults").val();
  var childs = $("#drop-childs").val();
  var idTrip = $("#drop-trips").val();
  if (idTrip != "" && dateVal != "" && adults > 0) {
    $("#container-prices").html("Please wait...<i class=\'fa fa-spin fa-refresh\'></i>")
    $.ajax({
      url: "'.Url::to(['/reservation/calc-price']).'?id_trip="+idTrip,
      type: "POST",
      data: {
        trip_date : dateVal,
        adults : adults,
        childs : childs
      },
      success: function(data){
        var result = JSON.parse(data);
        $("#container-prices").html("<p><span class=\'font-bold font-14\'>"+ result.currency +" "+ result.total_price +"</span> (<span class=\'font-12\'>IDR "+ result.total_price_idr+"</span>)</p>");
      }
    }); 
  }
});
  ', \yii\web\View::POS_READY);
$this->registerCss('
#form-date{
  background-color: #fff;
}
.picker__select--month, .picker__select--year{
  padding: 0px 10px;
  font-size: 21px;
}
  ');
 ?>
<!-- GALERY START -->
<!--App Screen-->
<!-- <section class="app-screen-sec" id="screens">
  <div class="container">
    <h2 class="text-center">Product Features<br><small>If one does not know to which port one is sailing, no wind is favorable.</small></h2>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image:url(img/screen-01.jpg)"></div>
            <div class="swiper-slide" style="background-image:url(img/screen-02.jpg)"></div>
            <div class="swiper-slide" style="background-image:url(img/screen-03.jpg)"></div>
            <div class="swiper-slide" style="background-image:url(img/screen-04.jpg)"></div>
            <div class="swiper-slide" style="background-image:url(img/screen-01.jpg)"></div>
            <div class="swiper-slide" style="background-image:url(img/screen-02.jpg)"></div>
            <div class="swiper-slide" style="background-image:url(img/screen-03.jpg)"></div>
            <div class="swiper-slide" style="background-image:url(img/screen-04.jpg)"></div>
        </div> -->    
        <!-- Add Pagination -->
<!--         <div class="swiper-pagination"></div>
</div>
  </div>
</section> -->
<!-- GALERY END -->
