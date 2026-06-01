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
	</div>

	<?php if(isset($data['id_BRAND'])) { ?>
		<input type="hidden" name="id_BRAND" value="<?php echo $data['id_BRAND']; ?>" />
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>