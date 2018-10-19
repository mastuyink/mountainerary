<?php
use yii\helpers\Html;
use yii\helpers\Url;
 ?>

 <div class="material-card">
 	<div class="align-center p-t-10"><h1 class="font-24 font-bold" id="title-container">Choose Your Payment</h1></div>
 	<div class="material-card_content">
 		<!-- <p>Choose Your PAyment</p> -->
 		<div class="row" id="radio-payment-container">
 			<?= Html::beginForm(['/reservation/payment'], 'post', ['enctype' => 'multipart/form-data','id'=>'form-payment']) ?>
      <?php foreach ($listPaymentMethod as $key => $paymentMethod): ?>
   			<div class="col-md-12 m-b-20">
            <label class="col-black">
              <?= Html::radio('payment_method', $paymentMethod['id'] == 2 ? true : false, [
                      'value' =>$paymentMethod['id'],
                      'class' => 'form-group radio-payment',
                      'id'    =>'radio-payment-'.$paymentMethod['id'],
              ]); ?>
              <?= $paymentMethod['label'] ?>
              <?php if(strlen($paymentMethod['logo']) > 5): ?>
                <img src="<?= $paymentMethod['logo'] ?>" class="img img-responsive pull-right">
              <?php endif; ?>
            </label>
   			</div>
      <?php endforeach; ?>
      <div class="col-md-12 p-t-20" id="btn-contaniner"> </div>
 			<?= Html::endForm() ?>
 		</div>
 	</div>
</div>

<?php
$this->registerJs('
renderPaypalButton();
$(".radio-payment").on("change", function(){
	$("#btn-contaniner").html(" ");
	var checkVal = $("#form-payment input[type=\'radio\']:checked").val();
	if (checkVal == 1) {
		renderSubmitButton();
	} else if (checkVal == 2) {
		renderPaypalButton();
	}
});

function renderPaypalButton(){
  renderLoading();
  $.ajax({
    url : "'.Url::to(["render-paypal-button"]).'",
    type: "POST",
    success: function (div) {
      $("#btn-contaniner").html(div);

    },
  });
}



function renderSubmitButton(){
	$("#btn-contaniner").html("<button id=\'btn-submit\' type=\'submit\' class=\'btn btn-lg bg-orange btn-block\'>Process<div class=\'ripple-container\'></div></button>");
}
$("#btn-submit").on("click",function(){
  renderLoading();
  return true;
});

function renderLoading(){
  $("#btn-contaniner").html("<center><p>Please Wait a moment...</p><img class=\'img img-responsive\' style=\'height:150px;\' src=\'/img/loading.svg\'></center>");
}
	', \yii\web\View::POS_READY);
 ?>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>