<ul id="reportInfo">
	<li class="title">Late to return cars report</li>
	<li>Creation date: <span><?php echo date("Y-m-d"); ?></span></li>
	<li>Car rent date range:
		<span>
			<?php
				if(!empty($data['dateFrom'])) {
					if(!empty($data['dateTo'])) {
						echo "from {$data['dateFrom']} to {$data['dateTo']}";
					} else {
						echo "from {$data['dateFrom']}";
					}
				} else {
					if(!empty($data['dateTo'])) {
						echo "to {$data['dateTo']}";
					} else {
						echo "unspecified";
					}
				}
			?>
		</span>
	</li>
</ul>
<?php
	if(sizeof($delayedCarsData) > 0) { ?>
		<table class="table">
			<thead>	
				<tr>
					<th>Contract</th>
					<th>Client</th>
					<th>Planned to return date</th>
					<th>Returned</th>
				</tr>
			</thead>

			<tbody>
				<?php
					// table creation
					foreach($delayedCarsData as $key => $val) {
						echo
							"<tr>"
								. "<td>#{$val['number']}, {$val['contract_date']}</td>"
								. "<td>{$val['name']} {$val['surname']}</td>"
								. "<td>{$val['return_date_time']}</td>"
								. "<td>{$val['returned']}</td>"
							. "</tr>";
					}
				?>
			</tbody>
		</table>
		<a href="index.php?module=report&action=contract_delayed_cars" title="New report" style="margin-bottom: 15px" class="button large float-right">New report</a>
<?php   
	} else { 
?>
		<div class="warningBox">

		</div>
<?php
	}
?>