<?php
    // we form breadcurmb element array
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('title' => 'Additional services'));

	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<!-- <a href='index.php?module=<?php echo $module; ?>&action=report' target="_blank">Service report</a> -->
	<a href='index.php?module=<?php echo $module; ?>&action=create'>New service</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Service was noty removed
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>name</th>
		<th></th>
	</tr>
	<?php
        // Table formation
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id_SERVICE']}</td>"
					. "<td>{$val['name']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id_SERVICE']}'>Edit</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_SERVICE']}\"); return false;'>Remove</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
// we include paging template
	include 'templates/common/paging.tpl.php';
?>