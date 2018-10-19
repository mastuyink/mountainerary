<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
		<div class="align-center"><h3>Contact Us</h3></div>
		<?php $form = ActiveForm::begin(['action'=>'/web/contact','id' => 'trip-contact-form']); ?>
		<?= Html::hiddenInput('returnUrl', $returnUrl); ?>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($emailForm, 'name')->textInput(['placeholder'=>'Your Name']); ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($emailForm, 'email')->textInput(['placeholder'=>'Your email']); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($emailForm, 'trip')->dropDownList($listTrip, ['prompt' => 'Select Trip..']); ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($emailForm, 'pax')->dropDownList(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10']); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($emailForm, 'departure_city')->textInput(['placeholder'=>'Departure City: Malang, Surabaya, Bali or Others']); ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($emailForm, 'date')->textInput(['placeholder' => 'Estimated Arrival Date','id'=>'form-contact-date']); ?>
			</div>
		</div>
		<?= $form->field($emailForm, 'message')->textarea(['rows'=>6,'placeholder' => 'Type your Additonal Informaition, e.g: Special request, group booking more than 4 participants drop off request need advise/suggestion or ETC']); ?>
		<div class="form-group col-md-12">
			<?= Html::submitButton('send' , ['class' => 'btn btn-warning btn-raised btn-lg btn-block']); ?>
		</div>
		<?php ActiveForm::end(); ?>
</div>
<?php
app\assets\DatePickerAsset::register($this);
$this->registerJs('
$("#form-contact-date").pickadate({
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
 ?>

