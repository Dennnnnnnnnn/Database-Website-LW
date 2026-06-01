<?php

$contractsObj = new contracts();

if(!empty($id)) {
    // remove ordered services
	$contractsObj->deleteOrderedServices($id);

    // remove contract
	$contractsObj->deleteContract($id);

    // redirect to the contracts page
	common::redirect("index.php?module={$module}&action=list");
	die();
}

?>