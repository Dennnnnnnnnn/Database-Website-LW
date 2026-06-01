<?php

// we create the contract object
$contractsObj = new contracts();

// we get the contract id from the http get parameters
$contractId = '';
if(isset($_GET['contractId'])) {
	$contractId = mysql::escapeFieldForSQL($_GET['contractId']);
}

$serviceId = '';
if(isset($_GET['serviceId'])) {
	$serviceId = mysql::escapeFieldForSQL($_GET['serviceId']);
}

$dateFrom = '';
if(isset($_GET['dateFrom'])) {
	$dateFrom = mysql::escapeFieldForSQL($_GET['dateFrom']);
}

if(!empty($contractId) && !empty($serviceId) && !empty($dateFrom)) {
	// we remove the seceted service
	$contractsObj->deleteOrderedService($contractId, $serviceId, $dateFrom);

	// we redirect to contract edit page
	common::redirect("index.php?module={$module}&action=edit&id={$contractId}");
	die();
}

?>