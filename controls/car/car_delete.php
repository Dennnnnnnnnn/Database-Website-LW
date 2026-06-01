<?php

$carsObj = new cars();

if(!empty($id)) {
	// check if the car is not included in any contract
	$count = $carsObj->getContractCountOfCar($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// remove car
		$carsObj->deleteCar($id);
	} else {
		// couldn't remove, because car is included in at least one contract, show error message
		$removeErrorParameter = '&remove_error=1';
	}

	// redirect to the cars page
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>