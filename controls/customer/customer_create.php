<?php

$customersObj = new customers();

$formErrors = null;
$data = array();

// establish the necessary fields
$required = array('pasport_id', 'name', 'surname', 'birth_date', 'phone_number');

// maximum length of the fields
$maxLengths = array (
    'pasport_id' => 11,
    'name' => 20,
    'surname' => 20
);

// submit button is pressed by user
if(!empty($_POST['submit'])) {

	// establish the field validation types
	$validations = array (
        'pasport_id' => 'positivenumber',
        'name' => 'alfanum',
        'surname' => 'alfanum',
        'birth_date' => 'date',
        'phone_number' => 'phone',
        'email' => 'email'
	);

	// create field validator class object
	$validator = new validator($validations, $required, $maxLengths);

	// fields filled with no errors
	if($validator->validate($_POST)) {
		// edit customer
		$customersObj->insertCustomer($_POST);

		// redirect user to customers page
		common::redirect("index.php?module={$module}&action=list");
		die();
	}
	else {
		// get error message
		$formErrors = $validator->getErrorHTML();
		// set the entered data values as the field value variable 
		$data = $_POST;
	}
}

// include template
include "templates/{$module}/{$module}_form.tpl.php";

?>