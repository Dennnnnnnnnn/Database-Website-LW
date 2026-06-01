<?php


$carsObj = new cars();
$brandsObj = new brands();
$modelsObj = new models();

$formErrors = null;
$data = array();

// establish the necessary fields
$required = array('model', 'state_number', 'manufacturing_date', 'gear_box', 'fuel_type', 'car_body_type', 'car_body_type', 'state', 'milage', 'number_of_seats', 'registration_date', 'value', 'luggage_size');

// maximum length of the fields
$maxLengths = array (
	'state_number' => 6
);

// submit button is pressed by user
if(!empty($_POST['submit'])) {
	
	// establish the field validation types
	$validations = array (
		'model' => 'positivenumber',
		'state_number' => 'alfanum',
		'gear_box' => 'positivenumber',
		'fuel_type' => 'positivenumber',
		'car_body_type' => 'positivenumber',
		'luggage_size' => 'positivenumber',
		'state' => 'positivenumber',
		'manufacturing_date' => 'date',
		'milage' => 'positivenumber',
		'number_of_seats' => 'positivenumber',
		'registration_date' => 'date',
		'value' => 'price'
		);

	// create field validator class object
	$validator = new validator($validations, $required, $maxLengths);

	// fields filled with no errors
	if($validator->validate($_POST)) {
		$data = $_POST;

		// arrange checkbox values
		if(isset($data['radio']) && $data['radio'] == 'on') {
			$data['radio'] = 1;
		} else {
			$data['radio'] = 0;
		}

		if(isset($data['music_player']) && $data['music_player'] == 'on') {
			$data['music_player'] = 1;
		} else {
			$data['music_player'] = 0;
		}

		if(isset($data['conditioner']) && $data['conditioner'] == 'on') {
			$data['conditioner'] = 1;
		} else {
			$data['conditioner'] = 0;
		}

		// create new entry
		$carsObj->insertCar($data);

		// redirect user to the cars page
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();
		// set the entered data values as the field value variable 
		$data = $_POST;
	}
} else {
	// check if the ID of the element is designated. If so, fill the form fields with data selected from element
	if(!empty($id)) {
		// select car
		$data = $carsObj->getCar($id);
	}
}

// include template
include "templates/{$module}/{$module}_form.tpl.php";
?>