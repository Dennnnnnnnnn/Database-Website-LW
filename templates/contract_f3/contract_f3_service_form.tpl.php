<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Custom services</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=edit&id=<?php echo $contractId; ?>">Edit custom services</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($serviceId) && !empty($dateFrom)) echo "Edit service"; else echo "New service"; ?></li>
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
		<label for="service">Service<?php echo in_array('service', $required) ? '<span> *</span>' : ''; ?></label>
		<select class="elementSelector form-select form-control" name="service" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?>>
			<?php
				$allServices = $servicesObj->getServicesList();
				foreach($allServices as $service) {
					echo "<optgroup label='{$service['name']}'>";
					$prices = $servicesObj->getServicePrices($service['id_SERVICE']);
					foreach($prices as $price) {
						$selected = "";
						if(isset($data['fk_SERVICE_PRICEvalid_from']) ) {
							if($data['fk_SERVICE_PRICEvalid_from'] == $price['valid_from'] && $data['fk_ID_SERVICE'] == $price['fk_SERVICEid_SERVICE']) {
								$selected = " selected='selected'";
							}
						}
						echo "<option{$selected} value='{$price['fk_SERVICEid_SERVICE']}#{$price['valid_from']}'>{$service['name']} {$price['price']} EUR ( {$price['valid_from']})</option>";
					}
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="price">Price<?php echo in_array('price', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="price" name="price" class="form-control" value="<?php echo isset($data['price']) ? $data['price'] : ''; ?>">
	</div>
	
	<div class="form-group">
		<label for="amount">Amount<?php echo in_array('amount', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="amount" name="amount" class="form-control" value="<?php echo isset($data['amount']) ? $data['amount'] : ''; ?>">
	</div>

	<?php if(isset($data['fk_CONTRACTnumber'])) { ?>
		<input type="hidden" name="fk_CONTRACTnumber" value="<?php echo $data['fk_CONTRACTnumber']; ?>" />
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>