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
		<label for="fk_Attendanceid_Attendance">Attendance ID<?php echo in_array('fk_Attendanceid_Attendance', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="fk_Attendanceid_Attendance" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="fk_Attendanceid_Attendance" class="form-control" value="<?php echo isset($data['fk_Attendanceid_Attendance']) ? $data['fk_Attendanceid_Attendance'] : ''; ?>">

		<label for="date">Date<?php echo in_array('date', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="date" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="date" class="form-control" value="<?php echo isset($data['date']) ? $data['date'] : ''; ?>">

		<label for="duration">Duration<?php echo in_array('duration', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="duration" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="duration" class="form-control" value="<?php echo isset($data['duration']) ? $data['duration'] : ''; ?>">

		<label for="calories_burned">Calories burned<?php echo in_array('calories_burned', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="calories_burned" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="calories_burned" class="form-control" value="<?php echo isset($data['calories_burned']) ? $data['calories_burned'] : ''; ?>">

		<label for="feedback">Feedback<?php echo in_array('feedback', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="feedback" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="feedback" class="form-control" value="<?php echo isset($data['feedback']) ? $data['feedback'] : ''; ?>">
	</div>

	<?php if(isset($data['id_BRAND'])) { ?>
		<input type="hidden" name="id_BRAND" value="<?php echo $data['id_BRAND']; ?>" />
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>