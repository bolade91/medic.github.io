<?php
include '../common.php';

$category_id = $_REQUEST["category_id"];	
if($category_id>0) {
	$filter = " AND category_id=".$category_id;
} else {
	$filter ='';
}

include 'calendars.php';
?>

