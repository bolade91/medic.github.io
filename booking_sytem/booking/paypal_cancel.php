<?php 
include 'common.php';

//get session values
if(isset($_SESSION["reservation_paypal_list"])) {
	$reservationObj->deleteReservations($_SESSION["reservation_paypal_list"]);
} 
unset($_SESSION["reservation_paypal_list"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Booking</title>

<link rel="stylesheet" href="css/mainstyle.css" type="text/css" />

<style type="text/css">

#redirect_link_button a {
	background-color: #333;
	display: block;
	padding:10px 20px;
	color: #fff;
	width: 330px;
	height: 30px;
	line-height: 30px;
	margin: 0 auto;
}

#redirect_link_button a:hover {
	background-color: #666;
}

</style>


<script language="javascript" type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.bxSlider.min.js"></script>
<script language="javascript" type="text/javascript" src="js/tmt_libs/tmt_core.js"></script>
<script language="javascript" type="text/javascript" src="js/tmt_libs/tmt_form.js"></script>
<script language="javascript" type="text/javascript" src="js/tmt_libs/tmt_validator.js"></script>
<script language="javascript" type="text/javascript" src="js/wach.calendar.js"></script>

</head>

<body>
<div style="text-align:center;width:960px; margin: 100px auto 0;">
	<div style="font-size: 30px;"><?php echo $langObj->getLabel("PAYPAL_CONFIRM_NOT_CONFIRMED_1"); ?></div>
    <div style="font-size: 20px; margin-top: 20px;"><?php echo $langObj->getLabel("PAYPAL_CONFIRM_NOT_CONFIRMED_2"); ?></div>
    
	<div id="redirect_link_button" style="font-size: 20px; margin-top: 20px;"><a href="index.php"><?php echo $langObj->getLabel("PAYPAL_CONFIRM_REDIRECT"); ?></a></div>
		
</div>
</body>
</html>