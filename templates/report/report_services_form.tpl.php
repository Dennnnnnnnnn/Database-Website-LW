<?php
	// breadcrumb array creation
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('link' => "index.php?module=report&action=list", 'title' => "Reports"), array("title" => "Selected service report"));
	
	// breadcrumb template
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
		<label for="dateFrom">Selected services from</label>
		<input type="text" id="dateFrom" name="dateFrom" class="form-control datepicker" value="<?php echo isset($data['dateFrom']) ? $data['dateFrom'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="dateTo">Selected services to</label>
		<input type="text" id="dateTo" name="dateTo" class="form-control datepicker" value="<?php echo isset($data['dateTo']) ? $data['dateTo'] : ''; ?>">
	</div>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Create report">
</form>