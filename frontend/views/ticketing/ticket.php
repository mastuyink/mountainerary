<?php 
require_once Yii::getAlias('@common')."/phpqrcode/qrlib.php";
$tempdir = Yii::$app->basePath."/E-Ticket/".$modelBooking->token."/";

$isi_teks = "http://mountainerary.com/".$modelBooking->id;
$qrcode = "QrCode-".$modelBooking->id.".png";
$quality  = 'L'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran   = 1; //batasan 1 paling kecil, 10 paling besar
$padding  = 1;
QRCode::png($isi_teks,$tempdir.$qrcode,$quality,$ukuran,$padding);
?>

<table width="100%" style="margin: 25px 0px; " cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<center><img class="img img-responsive" src="/img/logo.png"></center>
		</td>
	</tr>
</table>
<table width="100%" style="border-bottom: 1px solid #999999;border-top: 1px solid #999999" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td width="20%">
				<table width="100%">
						<tr>
							<td style="text-align: center; padding: 10px 20px;">
								<img class="img-responsive pull-left" alt="QrCode" style="width:10%; height:10%;" src="<?php echo $tempdir.$qrcode ?>" border="0">
								<p style="font-weight: bold; font-size: 18px; "><?= $modelBooking->id ?></p>
							</td>
						</tr>
				</table>
			</td>
			<td style="border-left: 1px solid #999999" width="50%">
				<table style="padding-left: 25px;" width="100%" >
					<tr>
						<td>
							<span  style="font-weight: bold; font-size: 15px; "><?= $modelBooking->idTrip->name ?></span>
							<br>
							<?= date('l d-F-Y',strtotime($modelBooking->trip_date)) ?>
							<br>
							<?= count($modelBooking->allPassengers) ?> PAX
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<br><p style="color: #999999; font-size: 24px; text-align: center; font-weight: bold;"><?= $modelBooking->idPaymentMethod->method ?></p>
<table class="table table-stripped">
	<caption>Buyer/Contact Detail</caption>
	<tbody>
		<tr>
			<td width="10%">Name</td>
			<td>: <?= $modelBooking->name ?></td>
		</tr>
		<tr>
			<td width="10%">Email</td>
			<td>: <?= $modelBooking->email ?></td>
		</tr>
		<tr>
			<td width="10%">Phone</td>
			<td>: <?= $modelBooking->phone ?></td>
		</tr>
	</tbody>
</table>
<?php if(!empty($modelBooking->shuttles)): ?>
<table class="table table-stripped">
	<caption>Shuttle Detail</caption>
	<thead>
		<tr>
			<th>No</th>
			<th>type</th>
			<th>Area</th>
			<th>Detail</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($modelBooking->shuttles as $no => $shuttle): ?>
		<tr>
			<td><?= $no+1 ?></td>
			<td><?= $shuttle->getShutleType() ?></td>
			<td><?= $shuttle->idArea->area ?></td>
			<td><?= $shuttle->description ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>
<table  class="table table-stripped">
	<caption>Travelers Detail</caption>
	<thead>
		<tr>
			<th width="10%">No</th>
			<th>Name</th>
			<th>Nationality</th>
			<th>Type</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($modelBooking->allPassengers as $key => $value): ?>
			<tr>
				<td><?= $key+1 ?></td>
				<td><?= $value->name ?></td>
				<td><?= $value->idNationality->nationality ?></td>
				<td><?= $value->getPassengerType()?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="page-break"> </div>

<div class="col-md-6">
	<p class="font-bold font-18 align-center bg-grey p-t-10 p-b-10">Itineraty <?= $modelBooking['idTrip']['name'] ?> At <?= date('D, d-M-Y',strtotime($modelBooking['trip_date'])) ?></p>
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
