<table class="table table-stripped table-responsive">
	<caption>Travelers Details</caption>
	<thead>
		<tr>
			<th width="50px;">No</th>
			<th>Name</th>
			<th>Type</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($trip->allPassengers as $key => $value): ?>
			<tr>
				<td><?= $key+1 ?></td>
				<td><?= $value->name.'<br><i>'.$value->idNationality->nationality.'</i>' ?></td>
				<td><?= $value->getPassengerType() ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>