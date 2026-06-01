<?php

$persTrainSessObj = new persTrainSess();

// count the sum number of entries
$elementCount = $persTrainSessObj->getPersTrainSessListCount();

// create paging class object
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// form list pages
$paging->process($elementCount, $pageId);

// select indicated page brands
$data = $persTrainSessObj->getPersTrainSessList($paging->size, $paging->first);

// include template
include "templates/{$module}/{$module}_list.tpl.php";

?>