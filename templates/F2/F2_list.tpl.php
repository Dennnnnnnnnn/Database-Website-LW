<?php
    // we form breadcrumb element array
	$breadcrumbItems = array(array('link' => 'index.php', 'title' => 'Home'), array('title' => 'Contracts'));
	include 'templates/common/breadcrumb.tpl.php';
?>

<div class="d-flex flex-row-reverse gap-3">
    <!--	<a href='index.php?module=<?php echo $module; ?>&action=report_delayed_cars'>Late to return cars report</a> -->
    <!-- <a href='index.php?module=<?php echo $module; ?>&action=report'>Contract report</a> -->
	<a href='index.php?module=<?php echo $module; ?>&action=create'>New contract</a>
</div>

<table class="table">
	<tr>
		<th>Member ID</th>
		<th>Membership level</th>
		<th>Name</th>
		<th>Workout name</th>
		<th>Staff name</th>
		<th></th>
	</tr>
	<?php
        // Table formation
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id_Member']}</td>"
					. "<td>{$val['membership']}</td>"
					. "<td>{$val['member_name']}</td>"
					. "<td>{$val['Workout_name']}</td>"
					. "<td>{$val['staff_name']}</td>"
					. "<td class='d-flex flex-row-reverse gap-2'>"
                        . "<a href='index.php?module={$module}&action=edit&id={$val['id_Member']}'>Edit</a>"
                        . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_Member']}\"); return false;'>Remove</a>"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
    // we include paging template
	include 'templates/common/paging.tpl.php';
?>