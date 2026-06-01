<?php

$employeesObj = new employees();

if(!empty($id)) {
	// check if the employee doesn't have any contracts
	$count = $employeesObj->getContractCountOfEmployee($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// remove employee
		$employeesObj->deleteEmployee($id);
	} else {
		// couldn't remove, because employee has at least one contract, show error message
		$removeErrorParameter = '&remove_error=1';
	}

	// redirect to the employees page
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>