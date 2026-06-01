<?php

$contractsObj = new contracts();
$servicesObj = new services();

// count the sum number of entries
$elementCount = $servicesObj->getServicesListCount();

$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);	

// form list pages
$paging->process($elementCount, $pageId);

// select indicated page services
$data = $servicesObj->getServicesList($paging->size, $paging->first);

// include template
include "templates/{$module}/{$module}_list.tpl.php";

?>