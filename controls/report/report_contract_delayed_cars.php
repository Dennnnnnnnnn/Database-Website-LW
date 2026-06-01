<?php

$contractsObj = new contracts();

$formErrors = null;
$fields = array();
$formSubmitted = false;

$data = array();
if(empty($_POST['submit'])) {
	// show report parameter entry form
    include "templates/{$module}/{$module}_delayed_cars_form.tpl.php";
} else {
	$formSubmitted = true;

	// establish the field validation types
	$validations = array (
			'dateFrom' => 'date',
			'dateTo' => 'date');

	// create validator class object
	$validator = new validator($validations);

	if($validator->validate($_POST)) {
		// select report data
		$delayedCarsData = $contractsObj->getDelayedCars($_POST['dateFrom'], $_POST['dateTo']);
		
		// show report
        include "templates/{$module}/{$module}_delayed_cars_show.tpl.php";
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();
		// get and set the entered field values
		$fields = $_POST;

		// show the report parameter entry form with errors and cancel any scenario execution
        include "templates/{$module}/{$module}_delayed_cars_form.tpl.php";
	}

}