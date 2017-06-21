<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	$_SESSION["qryReservationsFilterString"]="";
}

include 'reservation.php';
?>
