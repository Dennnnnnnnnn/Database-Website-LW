<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item" aria-current="page"><a href="index.php?module=<?php echo $module; ?>&action=list">Car models</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php if(!empty($id)) echo "Edit model"; else echo "New model"; ?></li>
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
		<label for="brand">Name<?php echo in_array('fk_brand', $required) ? '<span> *</span>' : ''; ?></label>
		<select id="brand" name="fk_brand" class="form-select form-control">
			<option value="-1">Select brand</option>
			<?php
				// se select all brands
				$brands = $brandsObj->getBrandList();
				foreach($brands as $key => $val) {
					$selected = "";
					if(isset($data['fk_brand']) && $data['fk_brand'] == $val['id_BRAND']) {
						$selected = " selected='selected'";
					}
					echo "<option{$selected} value='{$val['id_BRAND']}'>{$val['name']}</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="name">Name<?php echo in_array('name', $required) ? '<span> *</span>' : ''; ?></label>
		<input type="text" id="name" <?php if(isset($data['editing'])) { ?> readonly="readonly" <?php } ?> name="name" class="form-control" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
	</div>

	<?php if(isset($data['id_MODEL'])) { ?>
		<input type="hidden" name="id_MODEL" value="<?php echo $data['id_MODEL']; ?>" />
	<?php } ?>

	<p class="required-note">* marked fields are required</p>

	<input type="submit" class="btn btn-primary w-25" name="submit" value="Submit">
</form>