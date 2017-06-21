<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	$item_id = $_REQUEST["item_id"];	
	if($_REQUEST["reservation"] == "NO") {
        $query = $db->prepare("DELETE FROM booking_slots WHERE slot_id = ?");
        $query->execute(array($item_id));
	} else {
        $query = $db->prepare("UPDATE booking_slots SET slot_active = 0 WHERE slot_id = ?");
        $query->execute(array($item_id));
	}
}

include 'slots.php';
?>
