<?php


$membersObj = new members();

$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);


$elementCount = $membersObj->getMemberListCount();
$paging->process($elementCount, $pageId);


$data = $membersObj->getMemberList($paging->size, $paging->first);


include "templates/{$module}/{$module}_list.tpl.php";

?>