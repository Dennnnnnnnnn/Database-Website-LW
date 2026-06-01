<?php
	

$contractsObj = new contracts();


$servicesObj = new services();


$carsObj = new cars();


$employeesObj = new employees();

$customersObj = new customers();

$formErrors = null;
$data = array();
$data['selected_services'] = array();

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
		// check if there are no other contracts with the same number
		$amount = $contractsObj->checkIfContractNrExists($_POST['number']);

		if($amount > 0) {
			// form the error message
			$formErrors = "contract with same number already exists.";
			// set the entered data values as the field value variable 
			$data = $_POST;
		} else {
			// insert new contract
			$contractsObj->insertContract($_POST);

			// insert ordered services
			foreach($_POST['service'] as $keyForm => $serviceForm) {

				// get 'service ID', 'valid from' and 'price' values
				$tmp = explode("#", $serviceForm);
				$serviceId = $tmp[0];

				$priceFrom = $tmp[1];
				$price = $tmp[2];

				$contractsObj->insertOrderedService($_POST['number'], $priceFrom, $price, $_POST['amount'][$keyForm],$serviceId );
			}
		}

		// redirect user to the contracts page
		if($formErrors == null) {
			common::redirect("index.php?module={$module}&action=list");
			die();
		}
	} else {
		// get error message
		$formErrors = $validator->getErrorHTML();

		// set the entered data values as the field value variable 
		$data = $_POST;

		$data['selected_services'] = array();
		if(isset($_POST['service'])) {
			$i = 0;
			foreach($_POST['service'] as $key => $val) {
				// get 'service ID', 'valid from' and 'price' values
				$tmp = explode("#", $val);
				
				$serviceId = $tmp[0];
				$priceFrom = $tmp[1];
				$price = $tmp[2];
				
				$data['selected_services'][$i]['Id_SELECTED_SERVICE'] = $serviceId;
				$data['selected_services'][$i]['fk_SERVICE_PRICEvalid_from'] = $priceFrom;
				$data['selected_services'][$i]['price'] = $price;
				$data['selected_services'][$i]['amount'] = $_POST['amount'][$key];

				$i++;
			}
		}
	}
}

// add an empty value to the beginning of the ordered service array 
// so that hidden form fields are always displayed in the ordered service form,
// which we can copy and add the desired number of services
array_unshift($data['selected_services'], array());

// include template
include "templates/{$module}/{$module}_form.tpl.php";
?>