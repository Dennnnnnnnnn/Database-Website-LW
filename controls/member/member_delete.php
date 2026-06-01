<?php

$memberObj = new member();


if(!empty($id)) {
	// check if the brand being deleted is not tied to a model
	$count = $memberObj->getModelCountOfBrand($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// remove brand
		$memberObj->deleteMember($id);
	} else {
		// couldn't remove, because brand is tied to a model, show error message
		$removeErrorParameter = '&remove_error=1';
	}

	// redirect to the brands page
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>