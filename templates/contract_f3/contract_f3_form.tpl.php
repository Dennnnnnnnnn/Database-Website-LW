<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Contracts</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Contract edit"; else echo "New contract"; ?></li>
	</ol>
</nav>

<?php if($formErrors != null) { ?>
	<div class="alert alert-danger" role="alert">
        Empty or invalid fields:
		<?php 
			echo $formErrors;
		?>
	</div>
<?php } ?>


<form action="" method="post" class="d-grid gap-3">

	<h4 class="mt-3">Contract information</h4>
  	
	<div class="form-group">
		<label for="nr">number<?php echo in_array('number', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="number" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="number" class="form-control" value="<?php echo isset($data['number']) ? $data['number'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="contract_date">contract date<?php echo in_array('contract_date', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="contract_date" name="contract_date" class="form-control datepicker" value="<?php echo isset($data['contract_date']) ? $data['contract_date'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="fk_CUSTOMERpasport_id">customer<?php echo in_array('fk_CUSTOMERpasport_id', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_CUSTOMERpasport_id" name="fk_CUSTOMERpasport_id" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// we select clients
				$customers = $customersObj->getCustomersList();
				foreach($customers as $key => $val) {
					$selected = "";
					if(isset($data['fk_CUSTOMERpasport_id']) && $data['fk_CUSTOMERpasport_id'] == $val['pasport_id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['pasport_id']}'>{$val['name']} {$val['surname']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="fk_EMPLOYEEemploee_id">employee<?php echo in_array('fk_EMPLOYEEemploee_id', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_EMPLOYEEemploee_id" name="fk_EMPLOYEEemploee_id" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// we select users
				$employees = $employeesObj->getEmplyeesList();
				foreach($employees as $key => $val) {
					$selected = "";
					if(isset($data['fk_EMPLOYEEemploee_id']) && $data['fk_EMPLOYEEemploee_id'] == $val['employee_id']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['employee_id']}'>{$val['name']} {$val['surname']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="rent_date_time">rent date and time<?php echo in_array('rent_date_time', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="rent_date_time" name="rent_date_time" class="form-control datetimepicker" value="<?php echo isset($data['rent_date_time']) ? $data['rent_date_time'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="factual_return_date_time">planned return date and time<?php echo in_array('factual_return_date_time', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="factual_return_date_time" name="factual_return_date_time" class="form-control datetimepicker" value="<?php echo isset($data['factual_return_date_time']) ? $data['factual_return_date_time'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="faktine_grazinimo_data_laikas">actual return date and time<?php echo in_array('faktine_grazinimo_data_laikas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="faktine_grazinimo_data_laikas" name="faktine_grazinimo_data_laikas" class="form-control datetimepicker" value="<?php echo isset($data['faktine_grazinimo_data_laikas']) ? $data['faktine_grazinimo_data_laikas'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="state">state<?php echo in_array('state', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="state" name="state" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// we select the states
				$states = $contractsObj->getContractStates();
				foreach($states as $key => $val) {
					$selected = "";
					if(isset($data['state']) && $data['state'] == $val['id_CONTRACT_STATES']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_CONTRACT_STATES']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="price">rent price<?php echo in_array('price', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="price" name="price" class="form-control" value="<?php echo isset($data['price']) ? $data['price'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="total_price">total price with services<?php echo in_array('total_price', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="total_price" name="total_price" class="form-control" value="<?php echo isset($data['total_price']) ? $data['total_price'] : ''; ?>">
	</div>

	<h4 class="mt-3">Car information</h4>

	<div class="form-group">
		<label for="fk_CARid_CAR">car<?php echo in_array('fk_CARid_CAR', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_CARid_CAR" name="fk_CARid_CAR" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// we select the cars
				$cars = $carsObj->getCarList();
				foreach($cars as $key => $val) {
					$selected = "";
					if(isset($data['fk_CARid_CAR']) && $data['fk_CARid_CAR'] == $val['id_CAR']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_CAR']}'>{$val['state_number']} - {$val['brand']} {$val['model']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="fk_PARKING_LOTid_PARKING_LOT">pickup parking lot<?php echo in_array('fk_PARKING_LOTid_PARKING_LOT', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_PARKING_LOTid_PARKING_LOT" name="fk_PARKING_LOTid_PARKING_LOT" class="form-select form-control">
			<option value="">---------------</option>
			<?php
				// we select the parking lots
				$parkingLots = $contractsObj->getParkingLots();
				foreach($parkingLots as $key => $val) {
					$selected = "";
					if(isset($data['fk_PARKING_LOTid_PARKING_LOT']) && $data['fk_PARKING_LOTid_PARKING_LOT'] == $val['id_PARKING_LOT']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_PARKING_LOT']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="strating_milage">milage before rent<?php echo in_array('strating_milage', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="strating_milage" name="strating_milage" class="form-control" value="<?php echo isset($data['strating_milage']) ? $data['strating_milage'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="gas_amount_before_rent">gas amount before rent<?php echo in_array('gas_amount_before_rent', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="gas_amount_before_rent" name="gas_amount_before_rent" class="form-control" value="<?php echo isset($data['gas_amount_before_rent']) ? $data['gas_amount_before_rent'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="fk_PARKING_LOTid_PARKING_LOT1">return parking lot<?php echo in_array('fk_PARKING_LOTid_PARKING_LOT1', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_PARKING_LOTid_PARKING_LOT1" name="fk_PARKING_LOTid_PARKING_LOT1" class="form-select form-control">
			<option value="">---------------</option>
			<?php
            // we select the parking lots
				$parkingLots = $contractsObj->getParkingLots();
				foreach($parkingLots as $key => $val) {
					$selected = "";
					if(isset($data['fk_PARKING_LOTid_PARKING_LOT1']) && $data['fk_PARKING_LOTid_PARKING_LOT1'] == $val['id_PARKING_LOT']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_PARKING_LOT']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="return_milage">milage after rent<?php echo in_array('return_milage', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="return_milage" name="return_milage" class="form-control" value="<?php echo isset($data['return_milage']) ? $data['return_milage'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="gar_amount_after_return">gas amount after rent<?php echo in_array('gar_amount_after_return', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="gar_amount_after_return" name="gar_amount_after_return" class="form-control" value="<?php echo isset($data['gar_amount_after_return']) ? $data['gar_amount_after_return'] : ''; ?>">
	</div>

	<?php if(isset($data['number'])) { ?>
		<h4 class="mt-3">Additional services</h4>
	
		<div class="d-flex flex-row-reverse gap-3">
			<a href='index.php?module=<?php echo $module; ?>&action=service_create&contractId=<?php echo $id; ?>'>new service</a>
		</div>
	
		<?php if(!empty($data['selected_services']) && sizeof($data['selected_services']) > 0) { ?>
			<table class="table">
				<tr>
					<th>Service</th>
					<th>Price</th>
					<th colspan="2">Amount</th>
				</tr>
				<?php
					// Table data
					foreach($data['selected_services'] as $key => $orderedService) {
						echo
							"<tr>"
								. "<td>{$orderedService['name']} {$orderedService['price']} EUR ({$orderedService['fk_SERVICE_PRICEvalid_from']})</td>"
								. "<td>{$orderedService['price']}</td>"
								. "<td>{$orderedService['amount']}</td>"
								. "<td class='d-flex flex-row-reverse gap-2'>"
								. "<a href='index.php?module=contract_f3&action=service_edit&contractId={$data['number']}&serviceId={$orderedService['fk_ID_SERVICE']}&dateFrom={$orderedService['fk_SERVICE_PRICEvalid_from']}'>edit</a>"
								. "<a href='#' onclick='showOrderedServiceConfirmDialog(\"{$module}\", \"{$data['number']}\", \"{$orderedService['fk_ID_SERVICE']}\", \"{$orderedService['fk_SERVICE_PRICEvalid_from']}\"); return false;'>remove</a>"
								. "</td>"
							. "</tr>";
					}
				?>
			</table>
		<?php } ?>
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>