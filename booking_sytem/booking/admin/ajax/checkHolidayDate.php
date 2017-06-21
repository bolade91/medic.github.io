<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	if($_REQUEST["add_dates"] == 1) {
		$date = str_replace(",","-",$_REQUEST["date_from"]);		
		$check=$holidayObj->checkHolidayDate($date,"",$_GET["calendar_id"]);		
		echo $check;
	} else if($_REQUEST["add_dates"] == 2) {
		$date_from = str_replace(",","-",$_REQUEST["date_from"]);
		$date_to = str_replace(",","-",$_REQUEST["date_to"]);		
		$check=$holidayObj->checkHolidayDate($date_from,$date_to,$_GET["calendar_id"]);		
		echo $check;
	}
}
?>