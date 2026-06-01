<?php


$contractsObj = new contracts();
$servicesObj = new services();
$carsObj = new cars();
$employeesObj = new employees();
$customersObj = new customers();

$formErrors = null;
$data = array();

// establish the necessary fields
$required = array('number', 'contract_date', 'rent_date_time', 'return_date_time', 'strating_milage', 'price', 'gas_amount_before_rent', 'state', 'fk_CUSTOMERpasport_id', 'fk_EMPLOYEEemploee_id', 'fk_CARid_CAR', 'fk_PARKING_LOTid_PARKING_LOT1', 'fk_PARKING_LOTid_PARKING_LOT', 'amount');

// submit button is pressed by user
if(!empty($_POST['submit'])) {

    // establish the field validation types
    $validations = array (
        'number' => 'positivenumber',
        'contract_date' => 'date',
        'rent_date_time' => 'datetime',
        'return_date_time' => 'datetime',
        'factual_return_date_time' => 'datetime',
        'strating_milage' => 'int',
        'return_milage' => 'int',
        'price' => 'price',
        'gas_amount_before_rent' => 'int',
        'gar_amount_after_return' => 'int',
        'state' => 'positivenumber',
        'fk_CUSTOMERpasport_id' => 'alfanum',
        'fk_EMPLOYEEemploee_id' => 'alfanum',
        'fk_CARid_CAR' => 'positivenumber',
        'fk_PARKING_LOTid_PARKING_LOT1' => 'positivenumber',
        'fk_PARKING_LOTid_PARKING_LOT' => 'positivenumber',
        'amount' => 'int');
		
	// create field validator class object
	$validator = new validator($validations, $required);

	// fields filled with no errors
	if($validator->validate($_POST)) {
		// update contract
		$contractsObj->updateContract($_POST);

		// remove unneeded services and include new ones
		// get current services
		$servicesFromDb = $contractsObj->getOrderedServices($id);

		// if we can't find the service price in the received form array, remove it
		foreach($servicesFromDb as $serviceDb) {
			$found = false;
			if(isset($_POST['service'])) {
				foreach($_POST['service'] as $keyForm => $serviceForm) {
					// get 'service ID', 'valid from' and 'price' values
					$tmp = explode("#", $serviceForm);
					
					$serviceId = $tmp[0];
					$priceFrom = $tmp[1];
					$price = $tmp[2];
					
					if($serviceDb['Id_SELECTED_SERVICE'] == $serviceId && $serviceDb['fk_SERVICE_PRICEvalid_from'] == $priceFrom && $serviceDb['amount'] == $_POST['amount'][$keyForm]) {
						$found = true;
					}
				}
			}

			if(!$found) {
				// remove service price
				$contractsObj->deleteOrderedService($id, $serviceDb['fk_ID_SERVICE'], $serviceDb['fk_SERVICE_PRICEvalid_from'], $serviceDb['price']);
			}
		}
		
		if(isset($_POST['service'])) {
			foreach($_POST['service'] as $keyForm => $serviceForm) {
				// if we can't find the ordered service in the database, but it is in the form, include it

				// get 'service ID', 'valid from' and 'price' values
				$tmp = explode("#", $serviceForm);
				
				$serviceId = $tmp[0];
				$priceFrom = $tmp[1];
				$price = $tmp[2];

				$found = false;
				foreach($servicesFromDb as $serviceDb) {
					if($serviceDb['Id_SELECTED_SERVICE'] == $serviceId && $serviceDb['fk_SERVICE_PRICEvalid_from'] == $priceFrom && $serviceDb['amount'] == $_POST['amount'][$keyForm]) {
						$found = true;
					}
				}

				if(!$found) {
					// include service price
					$contractsObj->insertOrderedService($id, $priceFrom, $price, $_POST['amount'][$keyForm], $serviceId);
				}
			}
		}

		// redirect user to the contracts page
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();

		// set the entered data values as the field value variable 
		$data = $_POST;
		if(isset($_POST['service'])) {
			$i = 0;
			foreach($_POST['service'] as $key => $val) {
				// get 'service ID', 'valid from' and 'price' values 
				$tmp = explode("#", $val);
				
				$serviceId = $tmp[0];
				$priceFrom = $tmp[1];
				$price = $tmp[2];

				$data['selected_services'][$i]['fk_CONTRACTnumber'] = $id;
				$data['selected_services'][$i]['Id_SELECTED_SERVICE'] = $serviceId;
				$data['selected_services'][$i]['fk_SERVICE_PRICEvalid_from'] = $priceFrom;
				$data['selected_services'][$i]['price'] = $price;
				$data['selected_services'][$i]['amount'] = $_POST['amount'][$key];

				$i++;
			}
		}
		
		array_unshift($data['selected_services'], array());
	}
} else {
	// fill the form fields with data selected from element
	$data = $contractsObj->getContract($id);
	$data['selected_services'] = $contractsObj->getOrderedServices($id);

	// add an empty value to the beginning of the ordered service array 
	// so that hidden form fields are always displayed in the ordered service form,
	// which we can copy and add the desired number of services
	array_unshift($data['selected_services'], array());
}

// set attribute value that the entry is being edited to disable ID editing in the template
$data['editing'] = 1;

// include template
include "templates/{$module}/{$module}_form.tpl.php";

?>