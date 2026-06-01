<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Employees</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Edit employee"; else echo "New employee"; ?></li>
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
		<label for="employee_id">Employee ID<?php echo in_array('employee_id', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="employee_id" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="employee_id" class="form-control" value="<?php echo isset($data['employee_id']) ? $data['employee_id'] : ''; ?>">
	</div>

	<div class="form-group">
		<label for="name">Name<?php echo in_array('name', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="name" name="name" class="form-control" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="surname">Surname<?php echo in_array('surname', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="surname" name="surname" class="form-control" value="<?php echo isset($data['surname']) ? $data['surname'] : ''; ?>">
	</div>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>