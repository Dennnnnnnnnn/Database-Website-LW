<?php

// create customers class object
$customersObj = new customers();

// count the sum number of entries
$elementCount = $customersObj->getCustomersListCount();

// create paging class object
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// form list pages
$paging->process($elementCount, $pageId);

// select indicated page customers
$data = $customersObj->getCustomersList($paging->size, $paging->first);

// include template
include "templates/{$module}/{$module}_list.tpl.php";
?>