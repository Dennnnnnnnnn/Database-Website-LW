<?php
	// breadcrumb array creation
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('link' => "index.php?module={$module}&action=list", 'title' => "Car Brands"), array("title" => !empty($id) ? "Brand Edit" : "New Brand"));

	include 'templates/common/breadcrumb.tpl.php';
?>

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
		<label for="name">Name<?php echo in_array('name', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="name" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="name" class="form-control" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">

		<label for="surname">Surname<?php echo in_array('surname', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="surname" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="surname" class="form-control" value="<?php echo isset($data['surname']) ? $data['surname'] : ''; ?>">

		<label for="date_of_birth">Date of birth<?php echo in_array('date_of_birth', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="date_of_birth" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="date_of_birth" class="form-control" value="<?php echo isset($data['date_of_birth']) ? $data['date_of_birth'] : ''; ?>">

		<label for="gender">Gender<?php echo in_array('gender', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="gender" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="gender" class="form-control" value="<?php echo isset($data['gender']) ? $data['gender'] : ''; ?>">

		<label for="phone_number">Phone number<?php echo in_array('phone_number', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="phone_number" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="phone_number" class="form-control" value="<?php echo isset($data['phone_number']) ? $data['phone_number'] : ''; ?>">

		<label for="email">Email<?php echo in_array('email', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="email" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="email" class="form-control" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">

		<label for="adress">Adress<?php echo in_array('adress', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="adress" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="adress" class="form-control" value="<?php echo isset($data['adress']) ? $data['adress'] : ''; ?>">

		<label for="height">Height<?php echo in_array('height', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="height" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="height" class="form-control" value="<?php echo isset($data['height']) ? $data['height'] : ''; ?>">

		<label for="weight">Weight<?php echo in_array('weight', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="weight" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="weight" class="form-control" value="<?php echo isset($data['weight']) ? $data['weight'] : ''; ?>">

		<label for="membership_level">Membership<?php echo in_array('membership_level', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="membership_level" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="membership_level" class="form-control" value="<?php echo isset($data['membership_level']) ? $data['membership_level'] : ''; ?>">


	</div>

	<?php if(isset($data['id_Member'])) { ?>
		<input type="hidden" name="id_Member" value="<?php echo $data['id_Member']; ?>" />
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>