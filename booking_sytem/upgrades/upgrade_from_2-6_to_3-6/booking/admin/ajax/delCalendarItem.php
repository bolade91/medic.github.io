<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	$item_id = $_REQUEST["item_id"];	
	$calendarObj->delCalendars($item_id);
	
}


include 'calendars.php';
?>
