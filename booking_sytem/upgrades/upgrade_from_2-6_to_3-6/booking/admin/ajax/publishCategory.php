<?php
include '../common.php';

$item_id = $_REQUEST["category_id"];	
$query = $db->prepare("UPDATE booking_categories SET category_active = 1 WHERE category_id = ?");
$query->execute(array($item_id));



?>