<?php

$brandsObj = new brands();

$formErrors = null;
$data = array();

// establish the necessary fields
$required = array('name');

// maximum length of the fields
$maxLengths = array (
	'name' => 20
);

// submit button is pressed
if(!empty($_POST['submit'])) {
	// establish the field validation types
	$validations = array (
		'name' => 'anything');

	// create validator class object
	$validator = new validator($validations, $required, $maxLengths);

	if($validator->validate($_POST)) {
		// create new entry
		$brandsObj->insertBrand($_POST);

		// redirect to the brands page
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();
		// receive the entered field data
		$data = $_POST;
	}
}

// include template
include "templates/{$module}/{$module}_form.tpl.php";

?>