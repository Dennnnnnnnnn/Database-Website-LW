<?php
	// breadcrumb array creation
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('title' => 'Car brands'));

	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>New brand</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		 Brand was not removed. First remove all the models of selected brand.
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th></th>
	</tr>
	<?php
		// table creation
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id_BRAND']}</td>"
					. "<td>{$val['name']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id_BRAND']}'>Edit</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_BRAND']}\"); return false;'>Remove</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// inclusion of paging template
	include 'templates/common/paging.tpl.php';
?>