<?php

$employeesObj = new employees();

$formErrors = null;
$data = array();

// establish the necessary form fields
$required = array('employee_id', 'name', 'surname');

// maximum length of the fields
$maxLengths = array (
	'employee_id' => 6,
	'name' => 20,
	'surname' => 20
);

// submit button is pressed by user
if(!empty($_POST['submit'])) {

	// establish the field validation types
	$validations = array (
		'employee_id' => 'alfanum',
		'name' => 'alfanum',
		'surname' => 'alfanum');

	// create field validator class object
	$validator = new validator($validations, $required, $maxLengths);

	// fields filled with no errors
	if($validator->validate($_POST)) {
		// insert new employee
		$employeesObj->insertEmployee($_POST);

		// redirect user to employees page
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