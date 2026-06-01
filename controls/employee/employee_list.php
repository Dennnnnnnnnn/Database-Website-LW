<?php

// create employees class object
$employeesObj = new employees();

// count the sum number of entries
$elementCount = $employeesObj->getEmplyeesListCount();

// create paging class object
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// form list pages
$paging->process($elementCount, $pageId);

// select indicated page employees
$data = $employeesObj->getEmplyeesList($paging->size, $paging->first);

// include template
include "templates/{$module}/{$module}_list.tpl.php";

?>