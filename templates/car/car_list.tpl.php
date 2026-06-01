<?php
	// we form breadcrumb element array
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('title' => 'Cars'));
	
	// breadcurmbs template inclusion
	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>New car</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Car was not removed because it was included in at least one contract
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>State Number</th>
		<th>Model</th>
		<th>State</th>
		<th></th>
	</tr>
	<?php
		// Table formation
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id_CAR']}</td>"
					. "<td>{$val['state_number']}</td>"
					. "<td>{$val['brand']} {$val['model']}</td>"
					. "<td>{$val['state']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id_CAR']}'>Edit</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_CAR']}\"); return false;'>Remove</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// we include paging template
	include 'templates/common/paging.tpl.php';
?>