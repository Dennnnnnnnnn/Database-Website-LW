<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Custom services</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Edit service"; else echo "New service"; ?></li>
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
		<label for="name">name<?php echo in_array('name', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="name" name="name" class="form-control" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="description">description<?php echo in_array('description', $required) ? '<span> *</span>' : ''; ?></label>
		<textarea type="text" id="description" name="description" class="form-control"><?php echo isset($data['description']) ? $data['description'] : ''; ?></textarea>
	</div>

	<div class="row w-75">
		<div class="formRowsContainer column">
			<div class="row headerRow<?php if(empty($data['price']) || sizeof($data['price']) == 1) echo ' d-none'; ?>">
				<div class="col-4">price</div>
				<div class="col-4">valid from</div>
			</div>
			<?php
				if(!empty($data['service_prices']) && sizeof($data['service_prices']) > 0) {
					foreach($data['service_prices'] as $key => $val) {
						$disabledInputAttr = "";
						if((isset($val['inactive']) && $val['inactive'] == 1) || $key === 0) {
							$disabledInputAttr = "disabled='disabled'";
						}

						$disabledHiddenAttr = "";
						if($key === 0) {
							$disabledHiddenAttr = "disabled='disabled'";
						}

						$price = '';
						if(isset($val['price']) ) {
							$price = $val['price'];
						}

						$valid_from = '';
						if(isset($val['valid_from']) ) {
							$valid_from = $val['valid_from'];
						}

						$inactive = false;
						if(isset($val['inactive']) && $val['inactive'] == 1) {
							$inactive = true;
						}
					?>
						<div class="formRow row col-12 <?php echo $key > 0 ? '' : 'd-none'; ?>">
							<div class="col-4">
								<input type="text" class="form-control" <?php if($inactive == false) { ?>name="price[]"<?php } ?>value="<?php echo $price; ?>" <?php echo $disabledInputAttr ?> />
								<?php if($inactive) { ?>
									<input type="hidden" name="price[]" value="<?php echo $price; ?>" />
								<?php } ?>
							</div>
							<div class="col-4">
								<input type="text" class="form-control" <?php if($inactive == false) { ?>name="valid_from[]"<?php } ?>value="<?php echo $valid_from; ?>" <?php echo $disabledInputAttr ?> />
								<?php if($inactive) { ?>
									<input type="hidden" name="valid_from[]" value="<?php echo $valid_from; ?>" />
								<?php } ?>
							</div>
							<input type="hidden" class="isDisabledForEditing" name="inactive[]" value="<?php echo $inactive ? '1' : '0'; ?>" <?php echo $disabledHiddenAttr ?> />
							<div class="col-4"><a href="#" onclick="return false;" class="removeChild <?php echo $inactive ? 'd-none' : ''; ?>">Remove</a></div>
						</div>
					<?php 
					}
				}
					?>
		</div>
		<div class="w-100">
			<a href="#" class="addChild">Add</a>
		</div>
	</div>

	<?php if(isset($data['id_SERVICE'])) { ?>
			<input type="hidden" name="id_SERVICE" value="<?php echo $data['id_SERVICE']; ?>" />
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>