<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Itinerary of '.$trip['name'];

?>
<div class="row">
    <div class="material-card">
    <div class="material-card_content">
        <h1 class="font-24"><?= Html::encode($this->title) ?></h1>
    <table class="table table-stripped table-responsive">
        <caption>Time Stated is local time</caption>
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trip['tripTimelines'] as $key => $value): ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= date('D , d-M-Y',strtotime('+ '.$value['duration'].' DAYS',strtotime($modelReservation->trip_date))) ?><br><?= substr($value['time_start'],0,5).' - '.substr($value['time_end'],0,5) ?></td>
                    <td><?= $value['name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-8 service-block">
            <h2 class="text-center">Include</h2>
            <ul class="list-group">
            <?php foreach ($trip->includeServices as $include): ?>
                <div class="col-md-6">
                    <li class="list-group-item"><span class="glyphicon glyphicon-check"></span> <?= $include->idService->service ?></li>
                </div>
            <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-4 service-block">
            <h2 class="text-center">Exclude</h2>
            <ul class="list-group">
            <?php foreach ($trip->excludeServices as $exclude): ?>
                <li class="list-group-item"><span class="glyphicon glyphicon-remove-sign"></span> <?= $exclude->idService->service ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
</div>
</div>
<div class="row m-t-20">
    <!-- <div class="col-lg-12"> -->
        <div class="material-card card">
            <div class="font-bold font-24 align-center p-t-20">Fill Your Detail</div>
                <div class="material-card_content">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <div class="row">
                <div class="header"><h3>Buyer/Contact Detail</h3></div>
                <div class="col-md-4">
                   <?= $form->field($modelReservation, 'name')->textInput(['id' => 'form-buyer-name']); ?>
                </div>
                <div class="col-md-4">
                   <?= $form->field($modelReservation, 'email')->textInput(['id' => 'form-buyer-email']); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($modelReservation, 'phone')->textInput(['id' => 'form-buyer-phone'])->label('Phone/Whatsapp (if any)'); ?>
                </div>
            </div>
            <div class="row">
                <div class="header"><h3>Passengers Detail</h3></div>
                    <div class="header"><h4>Adults</h4></div>
                <?php for ($indexAdult=0; $indexAdult < $package['adults']; $indexAdult++): ?>
                    <div class="col-md-12">
                    <div class="col-md-4">
                        <!-- <div class="form-group label-floating">
                            <label for="form-passenger-name" class="control-label">Name</label> -->
                            <?= $form->field($modelPasengers, "[adults][$indexAdult]name")->textInput([
                                'id' => 'form-passenger-name-'.$indexAdult,
                                'class' => 'form-control',
                                'type' => 'passenger-name',
                            ]); ?>
                            <!-- <span class="help-block"></span>
                        </div> -->
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($modelPasengers, "[adults][$indexAdult]id_nationality")->dropDownList($listNationoality, [
                            'id'     => 'form-nationality-adults-'.$indexAdult,
                            'class'  => 'form-control form-nationality',
                            'prompt' => 'Select Nationality...'
                        ]); ?>
                    </div>
                    </div>
                <?php endfor; ?>

                <?php if($package['childs'] != null && $package['childs'] > 0): ?>
                    <div class="header"><h4>Childs</h4></div>
                    <?php for ($indexChild=0; $indexChild < $package['childs']; $indexChild++): ?>
                        <div class="col-md-12">
                        <div class="col-md-4">
                            <!-- <div class="form-group label-floating">
                                <label for="form-passenger-name" class="control-label">Name</label> -->
                                <?= $form->field($modelPasengers, "[childs][$indexChild]name")->textInput([
                                    'id' => 'form-passenger-name-'.$indexChild,
                                    'class' => 'form-control',
                                    'type' => 'passenger-name',
                                ]); ?>
                                <!-- <span class="help-block"></span>
                            </div> -->
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($modelPasengers, "[childs][$indexChild]id_nationality")->dropDownList($listNationoality, [
                                'id'=> 'form-nationality-childs-'.$indexChild,
                                'class' => 'form-control',
                                'prompt' => 'Select Nationality...'
                            ]); ?>
                        </div>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="header"><h3>Pickup & Drop Off</h3></div>
                <div class="col-md-6">
                    <?= $form->field($modelReservation, 'pickup')->checkbox([
                        'id' => 'checkbox-pickup',
                        'onchange'=>'
                          if($(this).is(":checked")){
                            $("#pickup-form").show(200);
                          }else{
                            $("#pickup-form").hide(200);
                          }'
                    ]); ?>
                    <div id="pickup-form" class="shuttle-hidden">
                        <?= $form->field($modelReservation, 'pickupArea')->dropDownList($listShuttleArea, ['id' => 'drop-pickup-area']); ?>
                        <?= $form->field($modelReservation, 'pickupDescription')->textarea(['placeholder'=>'Your Hotel Address Or Flight Time (Optional)']); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <?= $form->field($modelReservation, 'dropOff')->checkbox([
                        'id' => 'checkbox-drop',
                        'onchange'=>'
                          if($(this).is(":checked")){
                            $("#drop-form").show(200);
                          }else{
                            $("#drop-form").hide(200);
                          }'
                    ]); ?>
                    <div id="drop-form" class="shuttle-hidden">
                        <?= $form->field($modelReservation, 'dropOffArea')->dropDownList($listShuttleArea, ['id' => 'drop-drop-area']); ?>
                        <?= $form->field($modelReservation, 'dropOffDescription')->textarea(['placeholder'=>'Your Hotel Address Or Flight Time (Optional)']); ?>
                    </div>
                </div>
                 <div class="form-group col-md-12">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-lg bg-orange btn-warning btn-block']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
                </div>
        </div>
    <!-- </div> -->
</div>

<?php
$this->registerCss('
    .shuttle-hidden{
        display:none;
    }
');
$this->registerJs('
$("#form-nationality-adults-0").on("change",function(){
    $(".form-nationality").val($(this).val());
});
    ', \yii\web\View::POS_READY);
 ?>