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
		<th>Date</th>
		<th>Duration</th>
		<th>Calories burned</th>
		<th>Feedback</th>
		<th></th>
	</tr>
	<?php
		// table creation
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['Date']}</td>"
					. "<td>{$val['Duration']}</td>"
					. "<td>{$val['Calories_burned']}</td>"
					. "<td>{$val['Feedback']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id_Personal_training_session']}'>Edit</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_Personal_training_session']}\"); return false;'>Remove</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// inclusion of paging template
	include 'templates/common/paging.tpl.php';
?>