<?php
    // we form breadcrumb element array
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('title' => 'Employees'));

	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>New employee</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Employee was not remove cause he/she has active contracts
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>Employee ID</th>
		<th>Name</th>
		<th>Surname</th>
		<th></th>
	</tr>
	<?php
        // Table formation
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['employee_id']}</td>"
					. "<td>{$val['name']}</td>"
					. "<td>{$val['surname']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['employee_id']}'>Edit</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['employee_id']}\"); return false;'>Remove</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
    // we include paging template
	include 'templates/common/paging.tpl.php';
?>