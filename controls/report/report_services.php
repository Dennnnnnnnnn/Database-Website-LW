<?php

$servicesObj = new services();

$formErrors = null;
$fields = array();
$formSubmitted = false;

$data = array();
if(empty($_POST['submit'])) {
    include "templates/{$module}/{$module}_services_form.tpl.php";
	// show report parameter entry form
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
		$servicesData = $servicesObj->getOrderedServices($_POST['dateFrom'], $_POST['dateTo']);
		$servicesStats = $servicesObj->getStatsOfOrderedServices($_POST['dateFrom'], $_POST['dateTo']);
		
		// show report
        include "templates/{$module}/{$module}_services_show.tpl.php";
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();
		// get and set entered field values
		$fields = $_POST;
		
		// show the report parameter entry form with errors and cancel any scenario execution
        include "templates/{$module}/{$module}_services_form.tpl.php";
	}
}

