<?php

// create contracts class object
$contractsObj = new contracts();

// create paging class object
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// count the sum number of entries
$elementCount = $contractsObj->getContractListCount();

// form list pages
$paging->process($elementCount, $pageId);

// select indicated page contracts
$data = $contractsObj->getContractList($paging->size, $paging->first);

// include the template
include "templates/{$module}/{$module}_list.tpl.php";

?>