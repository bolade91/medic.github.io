<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	//first check if there are special slots to block user	
	$filterSpecial = " AND slot_special_text != ''";
	$filter = "";
	if(isset($_REQUEST["date_from"])  && !isset($_REQUEST["date_to"])) {
		$filterSpecial.=" AND slot_date  = '".str_replace(",","-",$_REQUEST["date_from"])."'";
		$filter.=" AND slot_date  = '".str_replace(",","-",$_REQUEST["date_from"])."'";
	} else if(isset($_REQUEST["date_from"]) && isset($_REQUEST["date_to"])) {
		$filterSpecial.=" AND slot_date  >= '".str_replace(",","-",$_REQUEST["date_from"])."' AND slot_date <= '".str_replace(",","-",$_REQUEST["date_to"])."'";
		$filter.=" AND slot_date  >= '".str_replace(",","-",$_REQUEST["date_from"])."' AND slot_date <= '".str_replace(",","-",$_REQUEST["date_to"])."'";
	}	
	$resultArray=$listObj->getSlotsList($filterSpecial,'',$_REQUEST["calendar_id"]);
	if(count($resultArray) > 0) {
	    echo 1;
	} else {
		//no special slots, but check for normal slots to prevent user to put special slots
		$resultArray=$listObj->getSlotsList($filter,'',$_REQUEST["calendar_id"]);
		if(count($resultArray) > 0) {
	       echo 2;
		} else {
			echo 0;
		}
	}
	
}
?>
