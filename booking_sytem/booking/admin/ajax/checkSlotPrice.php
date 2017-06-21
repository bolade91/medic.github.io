<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	$item_id = $_REQUEST["reservation_id"];	
	$reservationObj->setReservation($item_id);
	$slot_id=$reservationObj->getReservationSlotId();
	$slotsObj->setSlot($slot_id);
	$price=$slotsObj->getSlotPrice();
	echo $price;
}

?>