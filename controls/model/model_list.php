<?php

$modelsObj = new models();

// count the sum number of entries
$elementCount = $modelsObj->getModelListCount();

// create paging class object
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// form list pages
$paging->process($elementCount, $pageId);

// select indicated page models
$data = $modelsObj->getModelList($paging->size, $paging->first);

// include template
include "templates/{$module}/{$module}_list.tpl.php";
	
?>