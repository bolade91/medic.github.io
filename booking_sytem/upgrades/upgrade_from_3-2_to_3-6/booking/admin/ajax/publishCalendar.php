<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	$item_id = $_REQUEST["calendar_id"];	
	$query = $db->prepare("UPDATE booking_calendars SET calendar_active = 1 WHERE calendar_id = ?");
    $query->execute(array($item_id));
	
}

?>