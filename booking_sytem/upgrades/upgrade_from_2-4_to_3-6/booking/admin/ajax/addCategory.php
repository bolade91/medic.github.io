<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	$title = $_REQUEST["category_name"];
	
	$newid=$categoryObj->addCategory($title);
	
	include 'categories.php';
}
?>
<script>
	window.parent.showActionBar();
</script>