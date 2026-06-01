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
		<label for="fk_Memberid_Member">Member ID<?php echo in_array('fk_Memberid_Member', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="fk_Memberid_Member" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="fk_Memberid_Member" class="form-control" value="<?php echo isset($data['fk_Memberid_Member']) ? $data['fk_Memberid_Member'] : ''; ?>">

		<label for="date">Date<?php echo in_array('date', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="date" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="date" class="form-control" value="<?php echo isset($data['date']) ? $data['date'] : ''; ?>">

		<label for="attended">Attended<?php echo in_array('attended', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="attended" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="attended" class="form-control" value="<?php echo isset($data['attended']) ? $data['attended'] : ''; ?>">
	</div>

	<?php if(isset($data['id_Attendance'])) { ?>
		<input type="hidden" name="id_Attendance" value="<?php echo $data['id_Attendance']; ?>" />
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>