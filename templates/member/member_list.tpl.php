<?php
	// breadcrumb array creation
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('title' => 'Car brands'));

	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>New member</a>
</div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		 Member was not removed.
	</div>
<?php } ?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Surname</th>
		<th>Date of birth</th>
		<th>Gender</th>
		<th>Phone number</th>
		<th>Email</th>
		<th>Adress</th>
		<th>Height</th>
		<th>Weight</th>
	</tr>
	<?php
		// table creation
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id_Member']}</td>"
					. "<td>{$val['Name']}</td>"
					. "<td>{$val['Surname']}</td>"
					. "<td>{$val['Date_of_birth']}</td>"
					. "<td>{$val['Gender']}</td>"
					. "<td>{$val['Phone_number']}</td>"
					. "<td>{$val['Email']}</td>"
					. "<td>{$val['Adress']}</td>"
					. "<td>{$val['Height']}</td>"
					. "<td>{$val['Weight']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id_Member']}'>Edit</a>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_Member']}\"); return false;'>Remove</a>&nbsp;"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// inclusion of paging template
	include 'templates/common/paging.tpl.php';
?>