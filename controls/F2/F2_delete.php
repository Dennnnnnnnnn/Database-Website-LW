<?php

$membersObj = new members();

if(!empty($id)) {

	// remove contract
	// $membersObj->deleteAllPayments($id);
	// $membersObj->deleteAllWorkoutPlans($id);
	// $membersObj->deleteAllNotifications($id);
	// $membersObj->deleteAllAttendance($id);
	// $membersObj->deleteAllComplains($id);
	// $membersObj->deleteAllDietPlans($id);
	// $membersObj->deleteContract($id);
	$membersObj->deleteMember($id);

	



	// redirect to the contracts page
	common::redirect("index.php?module={$module}&action=list");
	die();
}

?>