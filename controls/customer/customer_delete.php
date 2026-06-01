<?php

$customersObj = new customers();

if(!empty($id)) {
	// check if the customer doesn't have any contracts
	$count = $customersObj->getContractCountOfCustomer($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// remove customer
		$customersObj->deleteCustomer($id);
	} else {
		// couldn't remove, because customer has at least one contract, show error message
		$removeErrorParameter = '&remove_error=1';
	}

	// redirect to the customers page
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>