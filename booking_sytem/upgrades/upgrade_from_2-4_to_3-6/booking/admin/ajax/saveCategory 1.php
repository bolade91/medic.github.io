<?php
include '../common.php';
$query = $db->prepare("UPDATE booking_categories SET category_name= ? WHERE category_id=?");
$query->execute(array($_REQUEST["name"],$_REQUEST["item_id"]));
	

?>
