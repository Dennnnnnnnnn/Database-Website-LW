<?php
    // we form breadcrumb element array
    $breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('title' => 'Contracts'));
	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>New Contract</a>
</div>

<table class="table">
	<tr>
		<th>Number</th>
		<th>Date</th>
		<th>Employee</th>
		<th>Customer</th>
		<th>State</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['number']}</td>"
					. "<td>{$val['contract_date']}</td>"
					. "<td>{$val['employee_name']} {$val['employee_surname']}</td>"
					. "<td>{$val['customer_name']} {$val['customer_surname']}</td>"
					. "<td>{$val['state']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
                        . "<a href='index.php?module={$module}&action=edit&id={$val['number']}'>Edit</a>"
                        . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['number']}\"); return false;'>Remove</a>"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
    // we include paging template
	include 'templates/common/paging.tpl.php';
?>