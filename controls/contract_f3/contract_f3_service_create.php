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

        // we explode the the variable to get valid_from price and fk_ID_SERVICE fields
		$tmp = explode("#", $data['service']);
				
		$data['fk_ID_SERVICE'] = $tmp[0];
		$data['fk_SERVICE_PRICEvalid_from'] = $tmp[1];


        // we check if the same service with same price have not yet been ordered
		$amount = $contractsObj->checkIfOrderedServiceExists($contractId, $data['fk_ID_SERVICE'], $data['fk_SERVICE_PRICEvalid_from']);

		if($amount > 0) {
			// we form error message
			$formErrors = "Service with selectied price already exists";
			
			//  we set the posted data to data variable
			$data = $_POST;
		} else {
			//  we store new selected service
			$contractsObj->insertOrderedService($contractId,$data['fk_SERVICE_PRICEvalid_from'],$data['price'], $data['amount'],$data['fk_ID_SERVICE'] );

			// we redirect to contract webpage
			common::redirect("index.php?module={$module}&action=edit&id={$contractId}");
			die();
		}

        // we redirect to contract webpage
		if($formErrors == null) {
			common::redirect("index.php?module={$module}&action=list");
			die();
		}
	} else {
		// we get all the errors
		$formErrors = $validator->getErrorHTML();
        //  we set the posted data to data variable
		$data = $_POST;
	}
}

// the template is included
include "templates/{$module}/{$module}_service_form.tpl.php";

?>