<?php

// create cars class object
$carsObj = new cars();

// count the sum number of entries
$elementCount = $carsObj->getCarListCount();

// create paging class object
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// form list pages
$paging->process($elementCount, $pageId);

// select indicated page cars
$data = $carsObj->getCarList($paging->size, $paging->first);	

// include template
include "templates/{$module}/{$module}_list.tpl.php";

?>