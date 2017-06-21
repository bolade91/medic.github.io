<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]>0) {
	$old = $_GET["old"];
    $query = $db->prepare("SELECT * FROM booking_admins WHERE admin_id=? AND admin_password=?");
    $query->execute(array($_SESSION["admin_id"],md5($old)));
	echo $query->rowCount();
}
?>