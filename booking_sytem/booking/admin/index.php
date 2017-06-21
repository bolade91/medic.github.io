<?php 
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
} else {
	header('Location: welcome.php');
}
?>