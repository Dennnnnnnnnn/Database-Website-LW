<?php

$brandsObj = new brands();

// count the sum number of entries
$elementCount = $brandsObj->getBrandListCount();

// create paging class object
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// form list pages
$paging->process($elementCount, $pageId);

// select indicated page brands
$data = $brandsObj->getBrandList($paging->size, $paging->first);

// include template
include "templates/{$module}/{$module}_list.tpl.php";

?>