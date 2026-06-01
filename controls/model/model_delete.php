<?php

$modelsObj = new models();

if(!empty($id)) {
	// check if the model is not in use, i.e. not assigned to any car
	$count = $modelsObj->getCarCountOfModel($id);

	$removeErrorParameter = '';
	if($count == 0) {
		// remove model
		$modelsObj->deleteModel($id);
	} else {
		// couldn't remove, because model is assigned to at least one car, show error message
		$removeErrorParameter = '&remove_error=1';
	}

	// redirect to models page
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>