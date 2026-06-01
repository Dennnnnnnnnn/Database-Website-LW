<?php

$brandsObj = new brands();
$modelsObj = new models();

$formErrors = null;
$data = array();

// establish the necessary fields
$required = array('name', 'fk_brand');

// maximum length of the fields
$maxLengths = array (
	'name' => 20
);

// submit button is pressed
if(!empty($_POST['submit'])) {
	// establish the field validation types
	$validations = array (
		'name' => 'anything',
		'fk_brand' => 'positivenumber');

	// create validator class object
	$validator = new validator($validations, $required, $maxLengths);

	// fields filled with no errors
	if($validator->validate($_POST)) {
		// update data
		$modelsObj->insertModel($_POST);

		// redirect to models page
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();
		// get and set the entered field values
		$data = $_POST;
	}
} else {
	// check if the ID of the element is designated. If so, fill the form fields with data selected from element
	if(!empty($id)) {
		$data = $modelsObj->getModel($id);
	}
}

// include template
include "templates/{$module}/{$module}_form.tpl.php";

?>