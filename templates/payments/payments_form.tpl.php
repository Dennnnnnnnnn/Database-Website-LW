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
		<label for="amount">Amount<?php echo in_array('amount', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="amount" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="amount" class="form-control" value="<?php echo isset($data['amount']) ? $data['amount'] : ''; ?>">

		<label for="payment_date">Payment date<?php echo in_array('payment_date', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="payment_date" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="payment_date" class="form-control" value="<?php echo isset($data['payment_date']) ? $data['payment_date'] : ''; ?>">
		
		<label for="payment_method">Payment method<?php echo in_array('payment_method', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="payment_method" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="payment_method" class="form-control" value="<?php echo isset($data['payment_method']) ? $data['payment_method'] : ''; ?>">

		<label for="payment_status">Payment status<?php echo in_array('payment_status', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="payment_status" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="payment_status" class="form-control" value="<?php echo isset($data['payment_status']) ? $data['payment_status'] : ''; ?>">

		<label for="discount">Discount<?php echo in_array('discount', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="discount" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="discount" class="form-control" value="<?php echo isset($data['discount']) ? $data['discount'] : ''; ?>">
	</div>

	<?php if(isset($data['id_Payments'])) { ?>
		<input type="hidden" name="id_Payments" value="<?php echo $data['id_Payments']; ?>" />
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>