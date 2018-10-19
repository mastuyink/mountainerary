<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Confirm Your Order";
 ?>

<div class="row">
        <div class="material-card">
            <div class="material-card_content">
                <div class="row">
        	<div class="align-center"><h1 class="font-bold font-24">Confirm Your Order</h1></div>
        	<div class="col-md-12 align-center m-t-10 m-t-10">
        		<?= Html::button('<span class="font-bold">Change Dates<span>', [
        			'class' => 'btn btn-transparent col-blue',
        			'onclick'=> '$("#div-change-date").toggle(200);'
        		]); ?>
        		<div id="div-change-date" class="row align-center" style="display: none;">
	        		<div class="col-md-2 col-md-offset-5">
	        			<?= Html::textInput('date', $modelBooking['trip_date'], ['class' => 'form-control','id'=>'form-change-date']); ?>
	        		</div>
        		</div>
        	</div>

    			<div class="col-md-6">
    				<p class="font-bold font-18 align-center bg-grey p-t-10 p-b-10">Itinerary <?= $modelBooking['idTrip']['name'] ?> At <?= date('D, d-M-Y',strtotime($modelBooking['trip_date'])) ?></p>
        		<table class="table table-stripped table-responsive">
        			<thead>
        				<tr>
	        				<th>NO</th>
	        				<th>Date</th>
	        				<th>Desciption</th>
	        			</tr>
        			</thead>
        			<tbody>
        				<?php foreach ($modelBooking['idTrip']['tripTimelines'] as $key => $value): ?>
        					<tr>
        						<td><?= $key+1 ?></td>
        						<td>
        							<span class="font-bold"><?= date('D, d-M-Y',strtotime('+ '.$value['duration'].' DAYS',strtotime($modelBooking['trip_date']))) ?></span><br>
        							<span class="font-italic font-12"><?= date('H:i',strtotime($value['time_start'])).'-'.date('H:i',strtotime($value['time_end'])) ?></span>
        						</td>
        						<td><?= $value['name'] ?></td>
        					</tr>
        				<?php endforeach; ?>
        			</tbody>
        		</table>
        		</div>
        		<div class="col-md-6">
        			<p class="font-bold font-18 align-center bg-grey p-t-10 p-b-10">Order Details</p>
                    <table class="table table-responsive table-stripped">
                        <thead>
                            <tr>
                                <th width="25px">No</th>
                                <th>Item</th>
                                <th width="125px;">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><?= count($modelBooking['allPassengers']) ?> Pax Tickets</td>
                                <td>
                                    <?= number_format($modelBooking['amount'],0).' '.$modelBooking['id_currency'] ?><br><span class="font-12">IDR <?= number_format($modelBooking['amount_idr']) ?></span>
                                </td>
                            </tr>
                            <tr class="font-bold">
                                <td colspan="2" class="align-center">Total</td>
                                <td>
                                    <?= number_format($modelBooking['amount'],0).' '.$modelBooking['id_currency'] ?>
                                    <br>
                                    <span class="font-12">IDR <?= number_format($modelBooking['amount_idr'],0) ?></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

        			<p class="m-t-20 font-bold font-18 align-center bg-grey p-t-10 p-b-10">Passengers Detail</p>
        			<table class="table table-responsive table-stripped">
        				<thead>
        					<tr>
        						<th width="25px">No</th>
        						<th>Name</th>
        						<th width="75px;">Type</th>
        					</tr>
        				</thead>
        				<tbody>
        					<?php foreach ($modelBooking['allPassengers'] as $passengerNo => $passenger): ?>
        						<tr>
        							<td><?= $passengerNo+1 ?></td>
        							<td><?= $passenger['name'] ?> <span class="font-italic font-12">(<?= $passenger['idNationality']['nationality'] ?>)</span></td>
        							<td>
        								<?php
        									if ($passenger['type'] == 1) {
        										echo "Adult";
        									}elseif ($passenger['type'] == 2) {
        										echo "Child";
        									}else{
        										echo "-";
        									}
        								 ?>
        							</td>
        						</tr>
        					<?php endforeach; ?>
        				</tbody>
        			</table>

                    <?php if(!empty($modelBooking['shuttles'])): ?>
            			<p class="m-t-20 font-bold font-18 align-center bg-grey p-t-10 p-b-10">Shuttle Detail</p>
                        <table class="table table-responsive table-stripped">
                            <thead>
                                <tr>
                                    <th width="25px">No</th>
                                    <th>Area</th>
                                    <th>Desc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($modelBooking['shuttles'] as $index => $shuttle): ?>
                                <tr>
                                    <td><?= $index+1 ?></td>
                                    <td>
                                        <?= $shuttle['type'] == true ? 'Pickup' : 'Drop Off' ?>
                                        At 
                                        <?= $shuttle['idArea']['area'] ?>
                                    </td>
                                    <td><?= $shuttle['description'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
            			<p><?= $modelBooking['note'] ?></p>
        			<?php endif; ?>
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Include</h4>
                            <ul class="list-group">
                            <?php foreach ($modelBooking->idTrip->includeServices as $include): ?>
                                    <li class="list-group-item"><span class="glyphicon glyphicon-check"></span> <?= $include->idService->service ?></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h4>Exclude</h4>
                            <ul class="list-group">
                            <?php foreach ($modelBooking->idTrip->excludeServices as $exclude): ?>
                                <li class="list-group-item"><span class="glyphicon glyphicon-remove-sign"></span> <?= $exclude->idService->service ?></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
        		</div>

            <div class="col-md-12">
                <?= Html::a('Process To Payment', ['payment'], [
                    'class' => 'btn bg-orange btn-lg btn-block',
                ]); ?>
            </div>
        </div>
        </div>
    </div>
</div>
</div>
<?php
app\assets\DatePickerAsset::register($this);
$this->registerJs('
$("#form-change-date").pickadate({
	min: +1,
	format: "yyyy-mm-dd",
	//hiddenPrefix: "prefix__",
	//hiddenSuffix: "__suffix",
	selectYears: true,
  	selectMonths: true,
	today: "",
	clear: "",
	close: "",
	closeOnSelect: false,
	closeOnClear: false,
});
$("#form-change-date").on("change",function(){
	$.ajax({
		url: "'.Url::to(['reservation/change-date']).'",
		type: "POST",
		data: {
			date: $(this).val()
		},
		success: function(){
			location.reload()
		}
	});
});
	', \yii\web\View::POS_READY);
?>