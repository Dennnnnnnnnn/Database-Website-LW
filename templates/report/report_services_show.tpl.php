<ul id="reportInfo">
	<li class="title">Selected services report</li>
	<li>Creation date: <span><?php echo date("Y-m-d"); ?></span></li>
	<li>Service selection date range:
		<span>
		<?php
			if(!empty($data['dateFrom'])) {
				if(!empty($data['dateTo'])) {
					echo "from {$data['dateFrom']} iki {$data['dateTo']}";
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
	if(sizeof($servicesData) > 0) { ?>
		<table class="table">
			<thead>	
				<tr>
					<th>ID</th>
					<th>Service</th>
					<th>Ordered with</th>
					<th>Ordered for Amount</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					// table creation
					foreach($servicesData as $key => $val) {
						echo
							"<tr>"
								. "<td>{$val['id_SERVICE']}</td>"
								. "<td>{$val['name']}</td>"
								. "<td>{$val['service_prices']}</td>"
								. "<td>{$val['total']} &euro;</td>"
							. "</tr>";
					}
				?>
				
				<tr>
					<td colspan='4'>Total</td>
				</tr>
				
				<tr>
					<td></td>
					<td></td>
					<td><?php echo "{$servicesStats[0]['service_prices']}"; ?></td>
					<td><?php echo "{$servicesStats[0]['total']}"; ?> &euro;</td>
				</tr>
			</tbody>
		</table>
		<a href="index.php?module=service&action=report" title="New report" style="margin-bottom: 15px" class="button large float-right">new report</a>
<?php   
	} else {
?>
		<div class="warningBox">
			There were no services selected in this date range.
		</div>
<?php
	}
?>