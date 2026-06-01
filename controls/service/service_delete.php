<?php

$servicesObj = new services();

if(!empty($id)) {
	// check if the service is not used in any contract
	$contractCount = $servicesObj->getContractCountOfService($id);

	$removeErrorParameter = '';
	if($contractCount == 0) {
		// remove service prices
		$servicesObj->deleteAllServicePrices($id);

		// remove service
		$servicesObj->deleteService($id);
	} else {
		// couldn't remove, because service is used in at least one contract, show error message
		$removeErrorParameter = '&remove_error=1';
	}

	// redirect to services page
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}
	
?>