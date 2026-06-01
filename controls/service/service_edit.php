<?php

$contractsObj = new contracts();
$servicesObj = new services();

$formErrors = null;
$data = array();

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
		// update data
		$servicesObj->updateService($_POST);

		// remove obsolete service prices and include new ones
		// get current service prices
		$servicePricesFromDb = $servicesObj->getServicePrices($id);

		// if we can't find a service price in the array from the data entry form, remove it
		foreach($servicePricesFromDb as $priceDb) {
			$found = false;
			if(isset($_POST['price'])) {
				foreach($_POST['price'] as $keyForm => $priceForm) {
					if($priceDb['price'] == $_POST['price'][$keyForm] && $priceDb['valid_from'] == $_POST['valid_from'][$keyForm]) {
						$found = true;
					}
				}
			}

			if(!$found) {
				// remove service price
				$servicesObj->deleteServicePrice($id, $priceDb['valid_from'], $priceDb['price']);
			}
		}

		if(isset($_POST['price'])) {
			foreach($_POST['price'] as $keyForm => $priceForm) {
				// if the service price is not in the database, but is in the form, include it
				$found = false;
				foreach($servicePricesFromDb as $priceDb) {
					if($priceDb['price'] == $_POST['price'][$keyForm] && $priceDb['valid_from'] == $_POST['valid_from'][$keyForm]) {
						$found = true;
					}
				}
	
				if(!$found) {
					// include service price
					$servicesObj->insertServicePrices($id, $_POST['valid_from'][$keyForm], $priceForm);
				}
			}
		}

		// redirect to services page
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();
		
		// get entered field values to fill out the form
		$data = $_POST;
		if(isset($_POST['price'])) {
			$i = 0;
			foreach($_POST['price'] as $key => $val) {
				$data['service_prices'][$i]['fk_SERVICEid_SERVICE'] = $id;
				$data['service_prices'][$i]['price'] = $val;
				$data['service_prices'][$i]['valid_from'] = $_POST['valid_from'][$key];
				$data['service_prices'][$i]['inactive'] = $_POST['inactive'][$key];
				$i++;
			}
		}

		array_unshift($data['service_prices'], array());
	}
} else {
	// check if the ID of the element is designated. If so, fill the form fields with data selected from element
	if(!empty($id)) {
		$data = $servicesObj->getService($id);
		$data['service_prices'] = array();
		
		$servicePrices = $servicesObj->getServicePrices($id);
		if(sizeof($servicePrices) > 0) {
			foreach($servicePrices as $key => $val) {
				// if the service price is used, disable its editing by deactivating its form field
				$priceCount = $contractsObj->getPricesCountOfOrderedServices($id, $val['valid_from']);
				if($priceCount > 0) {
					$val['incative'] = 1;
				}
				$data['service_prices'][] = $val;
			}
		}

		// add an empty value to the beginning of the ordered service array 
		// so that hidden form fields are always displayed in the ordered service form,
		// which we can copy and add the desired number of services
		array_unshift($data['service_prices'], array());
	}
}

// include template
include "templates/{$module}/{$module}_form.tpl.php";
?>