<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Start</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Cars</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Edit Car"; else echo "New Car"; ?></li>
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
	<div class="form-group">
		<label for="fk_model">model<?php echo in_array('model', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fk_model" name="fk_model" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// select all categories to generate the selection field
				$brands = $brandsObj->getBrandList();
				foreach($brands as $key => $val) {
					echo "<optgroup label='{$val['name']}'>";

					$models = $modelsObj->getModelListByBrand($val['id_BRAND']);
					foreach($models as $key2 => $val2) {
						$selected = "";
						if(isset($data['fk_model']) && $data['fk_model'] == $val2['id_MODEL']) {
							$selected = " selected='selected'";
						}
						echo "<option{$selected} value='{$val2['id_MODEL']}'>{$val2['name']}</option>";
					}
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="state_number">state number<?php echo in_array('state_number', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="state_number" name="state_number" class="form-control" value="<?php echo isset($data['state_number']) ? $data['state_number'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="manufacturing_date">manufacturing date<?php echo in_array('manufacturing_date', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="manufacturing_date" name="manufacturing_date" class="form-control datepicker" value="<?php echo isset($data['manufacturing_date']) ? $data['manufacturing_date'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="gear_box">gear box<?php echo in_array('gear_box', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="gear_box" name="gear_box" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// select all categories to generate the selection field
				$gearboxes = $carsObj->getGearboxList();
				foreach($gearboxes as $key => $val) {
					$selected = "";
					if(isset($data['gear_box']) && $data['gear_box'] == $val['id_GEAR_BOX_TYPE']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_GEAR_BOX_TYPE']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="fuel_type">fuel type<?php echo in_array('fuel_type', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="fuel_type" name="fuel_type" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// select all categories to generate the selection field
				$fueltypes = $carsObj->getFuelTypeList();
				foreach($fueltypes as $key => $val) {
					$selected = "";
					if(isset($data['fuel_type']) && $data['fuel_type'] == $val['id_FUEL_TYPES']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_FUEL_TYPES']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="car_body_type">car body type<?php echo in_array('car_body_type', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="car_body_type" name="car_body_type" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// select all categories to generate the selection field
				$bodytypes = $carsObj->getBodyTypeList();
				foreach($bodytypes as $key => $val) {
					$selected = "";
					if(isset($data['car_body_type']) && $data['car_body_type'] == $val['id_CAR_BODY_TYPES']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_CAR_BODY_TYPES']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="luggage_size">luggage_size<?php echo in_array('luggage_size', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="luggage_size" name="luggage_size" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// select all categories to generate the selection field
				$lugage = $carsObj->getLugageTypeList();
				foreach($lugage as $key => $val) {
					$selected = "";
					if(isset($data['luggage_size']) && $data['luggage_size'] == $val['id_LUGGAGE']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_LUGGAGE']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="state">state<?php echo in_array('state', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="state" name="state" class="form-select form-control">
			<option value="-1">---------------</option>
			<?php
				// select all categories to generate the selection field
				$car_states = $carsObj->getCarStateList();
				foreach($car_states as $key => $val) {
					$selected = "";
					if(isset($data['state']) && $data['state'] == $val['id_CAR_STATE']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_CAR_STATE']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="milage">milage<?php echo in_array('rida', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="milage" name="milage" class="form-control" value="<?php echo isset($data['milage']) ? $data['milage'] : ''; ?>">
	</div>

	<div class="form-group">
		<input type="checkbox" id="radio" name="radio" class="form-check-input"<?php echo (isset($data['radio']) && ($data['radio'] == 1 || $data['radio'] == 'on'))  ? ' checked="checked"' : ''; ?>>
		<label for="radio" class="form-check-label" for="radio">radio</label>
	</div>

	<div class="form-group">
		<input type="checkbox" id="music_player" name="music_player" class="form-check-input"<?php echo (isset($data['music_player']) && ($data['music_player'] == 1 || $data['music_player'] == 'on'))  ? ' checked="checked"' : ''; ?>>
		<label for="music_player" class="form-check-label" for="music_player">music player</label>
	</div>

	<div class="form-group">
		<input type="checkbox" id="conditioner" name="conditioner" class="form-check-input"<?php echo (isset($data['conditioner']) && ($data['conditioner'] == 1 || $data['conditioner'] == 'on'))  ? ' checked="checked"' : ''; ?>>
		<label for="conditioner" class="form-check-label" for="conditioner">conditioner</label>
	</div>

	<div class="form-group">
		<label for="number_of_seats">number of seats<?php echo in_array('number_of_seats', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="number_of_seats" name="number_of_seats" class="form-control" value="<?php echo isset($data['number_of_seats']) ? $data['number_of_seats'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="registration_date">registration date<?php echo in_array('registration_date', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="registration_date" name="registration_date" class="form-control datepicker" value="<?php echo isset($data['registration_date']) ? $data['registration_date'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="value">value<?php echo in_array('value', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="value" name="value" class="form-control" value="<?php echo isset($data['value']) ? $data['value'] : ''; ?>">
	</div>

	<?php if(isset($data['id_CAR'])) { ?>
		<input type="hidden" name="id_CAR" value="<?php echo $data['id_CAR']; ?>" />
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>