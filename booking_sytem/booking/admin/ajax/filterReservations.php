<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	//filter management
	if(isset($_REQUEST["date_from"]) && !isset($_REQUEST["date_to"])) {
		$_SESSION["qryReservationsFilterString"] = "AND slot_date = '".str_replace(",","-",$_REQUEST["date_from"])."'";
	} else if(isset($_REQUEST["date_from"]) && isset($_REQUEST["date_to"])) {
		$_SESSION["qryReservationsFilterString"] = "AND slot_date >= '".str_replace(",","-",$_REQUEST["date_from"])."' AND slot_date <= '".str_replace(",","-",$_REQUEST["date_to"])."'";
	}
}

include 'reservation.php';
?>
