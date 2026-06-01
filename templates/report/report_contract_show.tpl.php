<ul id="reportInfo">
	<li class="title"> Signed contracts reports</li>
	<li>Contract date: <span><?php echo date("Y-m-d"); ?></span></li>
	<li>Contact date period:
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
					echo "not specified";
				}
			}
		?>
		</span>
	</li>
</ul>
<?php
	if(sizeof($contractData) > 0) { ?>
		<table class="table">
			<thead>	
				<tr>
					<th>Contract</th>
					<th>Date</th>
					<th>Signed contracts value</th>
					<th>Selected services value</th>
				</tr>
			</thead>

			<tbody>
				<?php
					// table creation
					for($i = 0; $i < sizeof($contractData); $i++) {
						
						if($i == 0 || $contractData[$i]['pasport_id'] != $contractData[$i-1]['pasport_id']) {
							echo
								"<tr class='table-primary'>"
									. "<td colspan='4'>{$contractData[$i]['name']} {$contractData[$i]['surname']}</td>"
								. "</tr>";
						}
						
						if($contractData[$i]['contract_service_price'] == 0) {
							$contractData[$i]['contract_service_price'] = "not ordered";
						} else {
							$contractData[$i]['contract_service_price'] .= " &euro;";
						}
						
						echo
							"<tr>"
								. "<td>#{$contractData[$i]['number']}</td>"
								. "<td>{$contractData[$i]['contract_date']}</td>"
								. "<td>{$contractData[$i]['contract_price']} &euro;</td>"
								. "<td>{$contractData[$i]['contract_service_price']}</td>"
							. "</tr>";
						if($i == (sizeof($contractData) - 1) || $contractData[$i]['pasport_id'] != $contractData[$i+1]['pasport_id']) {
							if($contractData[$i]['total_client_contact_price'] == 0) {
								$contractData[$i]['total_client_contact_price'] = "not ordered";
							} else {
								$contractData[$i]['total_client_contact_price'] .= " &euro;";
							}
							
							echo 
								"<tr>"
									. "<td colspan='2'></td>"
									. "<td>{$contractData[$i]['total_client_contact_price']} &euro;</td>"
									. "<td>{$contractData[$i]['total_client_services_price']}</td>"
								. "</tr>";
						}
					}
				?>
				
				<tr>
					<td colspan='4'>Total sum</td>
				</tr>
				
				<tr>
					<td colspan="2"></td>
					<td><?php echo $totalPrice[0]['rent_sum']; ?> &euro;</td>
					<td>
						<?php
							if($totalServicePrice[0]['services_sum'] == 0) {
								$totalServicePrice[0]['services_sum'] = "not ordered";
							} else {
								$totalServicePrice[0]['services_sum'] .= " &euro;";
							}
							
							echo $totalServicePrice[0]['services_sum'];
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<a href="index.php?module=contract&action=report" title="New report" style="margin-bottom: 15px" class="button large float-right">new report</a>
<?php   
	} else {
?>
		<div class="warningBox">
			 In data range selected no contracts were signed.
		</div>
<?php
	}
?>