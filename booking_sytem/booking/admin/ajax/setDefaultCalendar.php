<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	$calendarObj->setDefaultCalendar($_GET["calendar_id"],$_GET["category_id"]);
}
?>
