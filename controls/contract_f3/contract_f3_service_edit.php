<?php

// we create the requirede class obejcts
$contractsObj = new contracts();
$servicesObj = new services();
$carsObj = new cars();
$employeesObj = new employees();
$customersObj = new customers();

$formErrors = null;
$data = array();

// we get the id of the contract we are edditing from the get array
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

// we set the required fields
$required = array('price', 'amount');

// the users submited new data
if(!empty($_POST['submit'])) {
    // we set the validation types for form input fields
	$validations = array (
		'price' => 'positivenumber',
		'amount' => 'positivenumber'
	);

    // new validator object is created
	$validator = new validator($validations, $required);

    // the input is valid
	if($validator->validate($_POST)) {
        // we form the input field array for the SQL query
		$data = $_POST;

        // we explode the the variable to get data
		$tmp = explode("#", $data['service']);
				
		$data['fk_ID_SERVICE'] = $tmp[0];
		$data['fk_SERVICE_PRICEvalid_from'] = $tmp[1];
		
		// we update the selected services table
		$contractsObj->updateOrderedService($data);

		// we redirect to contract page with contractId
		common::redirect("index.php?module={$module}&action=edit&id={$contractId}");
		die();
	} else {
        // we get all the errors
		$formErrors = $validator->getErrorHTML();
		//  we set the posted data to data variable
		$data = $_POST;
	}
} else {
	// we select and fill in the form with existing data for the service
	$data = $servicesObj->getOrderedService($contractId, $dateFrom, $serviceId);
}

// we set the state of editing if we want to remove the possibility to edit
$data['editing'] = 1;

// the template is included
include "templates/{$module}/{$module}_service_form.tpl.php";

?>