<?php
	

$contractsObj = new contracts();
$servicesObj = new services();

$formErrors = null;
$data = array();
$data['service_prices'] = array();

// establish the necessary fields
$required = array('name', 'price', 'valid_from');

// maximum length of the fields
$maxLengths = array (
	'name' => 40,
	'description' => 300
);

// submit button is pressed
if(!empty($_POST['submit'])) {
	// establish the field validation types
	$validations = array (
		'name' => 'anything',
		'description' => 'anything',
		'price' => 'price',
		'valid_from' => 'date');

	// create validator class object
	$validator = new validator($validations, $required, $maxLengths);
	
	// fields filled with no errors
	if($validator->validate($_POST)) {
		// insert new service and get its id
		$id = $servicesObj->insertService($_POST);

		// insert service prices
		foreach($_POST['price'] as $keyForm => $priceForm) {
			$servicesObj->insertServicePrices($id, $_POST['valid_from'][$keyForm], $_POST['price'][$keyForm]);
		}

		// redirect to services page
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();
		// get and set the entered field values
		$data = $_POST;

		$data['service_prices'] = array();
		if(isset($_POST['price']) && sizeof($_POST['price']) > 0) {
			$i = 0;
			foreach($_POST['price'] as $key => $val) {
				$data['service_prices'][$i]['price'] = $val;
				$data['service_prices'][$i]['valid_from'] = $_POST['valid_from'][$key];
				$i++;
			}
		}
	}
}

// add an empty value to the beginning of the ordered service array 
// so that hidden form fields are always displayed in the ordered service form,
// which we can copy and add the desired number of services
array_unshift($data['service_prices'], array());

// include template
include "templates/{$module}/{$module}_form.tpl.php";

?>