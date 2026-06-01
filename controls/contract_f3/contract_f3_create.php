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

// establish the necessary fields
$required = array('number', 'contract_date', 'rent_date_time', 'return_date_time', 'strating_milage', 'price', 'gas_amount_before_rent', 'state', 'fk_CUSTOMERpasport_id', 'fk_EMPLOYEEemploee_id', 'fk_CARid_CAR', 'fk_PARKING_LOTid_PARKING_LOT1', 'fk_PARKING_LOTid_PARKING_LOT', 'amount');

// the form submit was hit
if(!empty($_POST['submit'])) {
	// we set the validation rules
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
		// we check if the contract with the same number exists
		$kiekis = $contractsObj->checkIfContractNrExists($_POST['number']);

		if($kiekis > 0) {
			// sudarome klaidų pranešimą
            $formErrors = "contract with same number already exists.";
			// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
			$data = $_POST;
		} else {
			// įrašome naują sutartį
			$contractsObj->insertContract($_POST);

			// nukreipiame vartotoją į sutarčių puslapį
			common::redirect("index.php?module={$module}&action=edit&id={$_POST['nr']}");
			die();
		}
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
	}
}

// įtraukiame šabloną
include "templates/{$module}/{$module}_form.tpl.php";

?>