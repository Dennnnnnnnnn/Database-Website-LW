<?php
    // we form breadcrumb element array
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('title' => 'Car models'));

	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>New model</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
        Model was not removed. First you need to remove all cars of selected model.
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Brand</th>
		<th>Model</th>
		<th></th>
	</tr>
	<?php
        // Table formation
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id_MODEL']}</td>"
					. "<td>{$val['brand']}</td>"
					. "<td>{$val['name']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id_MODEL']}'>Edit</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_MODEL']}\"); return false;'>Remove</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
    // we include paging template
	include 'templates/common/paging.tpl.php';
?>