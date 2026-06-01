<?php

// sukuriame užklausų klasių objektus
$contractsObj = new contracts();
$servicesObj = new services();
$carsObj = new cars();
$employeesObj = new employees();
$customersObj = new customers();

$formErrors = null;
$data = array();
$data['selected_services'] = array();

/// establish the necessary fields
$required = array('number', 'contract_date', 'rent_date_time', 'return_date_time', 'strating_milage', 'price', 'gas_amount_before_rent', 'state', 'fk_CUSTOMERpasport_id', 'fk_EMPLOYEEemploee_id', 'fk_CARid_CAR', 'fk_PARKING_LOTid_PARKING_LOT1', 'fk_PARKING_LOTid_PARKING_LOT', 'amount');

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
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

    // creation of the validator object
	$validator = new validator($validations, $required);

    // if fields are valid
	if($validator->validate($_POST)) {
		// we update the contract
		$contractsObj->updateContract($_POST);

		// and redirect the user to contract list
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// otherwise we  throw error message
		$formErrors = $validator->getErrorHTML();

		// and return the values that were inputed by user
		$data = $_POST;
		$data['selected_services'] = $contractsObj->getOrderedServices($id);
	}
} else {
	//  we select the element data and fill in the fields using them.
	$data = $contractsObj->getContract($id);
	$data['selected_services'] = $contractsObj->getOrderedServices($id);
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
// we set the state that the field can be edited, for the purpose to turn of editing in the template
$data['editing'] = 1;

// we include the template
include "templates/{$module}/{$module}_form.tpl.php";

?>