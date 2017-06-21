<?php
include '../common.php';

$item_id = $_REQUEST["item_id"];	

$categoryObj->delCategories($item_id);

include 'categories.php';
?>

