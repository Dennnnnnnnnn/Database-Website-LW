<?php

$contractsObj = new contracts();
$formErrors = null;
$fields = array();

$data = array();
if(empty($_POST['submit'])) {
    include "templates/{$module}/{$module}_contract_form.tpl.php";
	// show report parameter entry form
} else {
	// establish the field validation types
	$validations = array (
		'dateFrom' => 'date',
		'dateTo' => 'date'
	);

	// create validator class object
	$validator = new validator($validations);

	if($validator->validate($_POST)) {
		// select report data
		$contractData = $contractsObj->getCustomerContracts($_POST['dateFrom'], $_POST['dateTo']);
		$totalPrice = $contractsObj->getSumPriceOfContracts($_POST['dateFrom'], $_POST['dateTo']);
		$totalServicePrice = $contractsObj->getSumPriceOfOrderedServices($_POST['dateFrom'], $_POST['dateTo']);
		
		// pass the date filter values to the template
		$data['dateFrom'] = $_POST['dateFrom'];
		$data['dateTo'] = $_POST['dateTo'];
		
		// show report
		include "templates/{$module}/{$module}_contract_show.tpl.php";
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();
		// get and set the entered field values
		$fields = $_POST;

		// show the report parameter entry form with errors
		include "templates/{$module}/{$module}_contract_form.tpl.php";
	}
}