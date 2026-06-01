<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Clients</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Edit client"; else echo "New client"; ?></li>
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
		<label for="pasport_id">passport id<?php echo in_array('pasport_id', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="pasport_id" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="pasport_id" class="form-control" value="<?php echo isset($data['pasport_id']) ? $data['pasport_id'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="name">name<?php echo in_array('name', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="name" name="name" class="form-control" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="surname">surname<?php echo in_array('pavarde', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="surname" name="surname" class="form-control" value="<?php echo isset($data['surname']) ? $data['surname'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="birth_date">birth date<?php echo in_array('birth_date', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="birth_date" name="birth_date" class="form-control datepicker" value="<?php echo isset($data['birth_date']) ? $data['birth_date'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="phone_number">phone number<?php echo in_array('phone_number', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="phone_number" name="phone_number" class="form-control" value="<?php echo isset($data['phone_number']) ? $data['phone_number'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="email">email<?php echo in_array('epastas', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="email" id="email" name="email" class="form-control" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
	</div>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>