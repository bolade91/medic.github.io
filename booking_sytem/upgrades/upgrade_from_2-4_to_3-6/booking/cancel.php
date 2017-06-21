<?php 
include 'common.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
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
<?php
//check if reservation is passed
if(!$reservationObj->isPassed($_GET["reservations"])) {
$calendar_id = $reservationObj->cancelReservations($_GET["reservations"]);
 ?>

<div style="text-align:center;width:960px; margin: 100px auto 0;">
	<div style="font-size: 30px;"><?php echo $langObj->getLabel("CANCEL_RESERVATION_CONFIRMED"); ?></div>
    <div style="font-size: 20px; margin-top: 20px;"><?php echo $langObj->getLabel("CANCEL_RESERVATION_CONFIRMED_2"); ?></div>
    
    <?php
	if($settingObj->getCancelRedirect() != '') {
		?>
		<div id="redirect_link_button" style="font-size: 20px; margin-top: 20px;"><a href="<?php echo $settingObj->getCancelRedirect(); ?>"><?php echo $langObj->getLabel("CANCEL_REDIRECT"); ?></a></div>
		<?php
	} else {
		?>
		<div id="redirect_link_button" style="font-size: 20px; margin-top: 20px;"><a href="index.php?calendar_id=<?php echo $calendar_id; ?>"><?php echo $langObj->getLabel("CANCEL_REDIRECT"); ?></a></div>
		<?php
	}
	?>
    </div>
    <?php 
	
	//send reservation email to admin
	$to = $settingObj->getEmailReservation();
	
	$subject = $langObj->getLabel("CANCEL_MAIL_ADMIN_SUBJECT");
	$message=$langObj->getLabel("CANCEL_MAIL_ADMIN_MESSAGE1").'<a href="'.$settingObj->getSiteDomain().'/admin/reservations.php">'.$langObj->getLabel("CANCEL_MAIL_ADMIN_MESSAGE2").'</a><br />';
	//get reservations details
	$resDetailsArr=$reservationObj->getReservationsDetails($_GET["reservations"]);
	
	foreach($resDetailsArr as $reservationId =>$reservation) {
		$calendarObj->setCalendar($reservation["calendar_id"]);
		if(in_array("reservation_name",$settingObj->getVisibleFields())) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE2")."</strong>: ".$reservation["reservation_name"]."<br>";
		}
		if(in_array("reservation_surname",$settingObj->getVisibleFields())) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE3")."</strong>: ".$reservation["reservation_surname"]."<br>";
		}
		if(in_array("reservation_email",$settingObj->getVisibleFields())) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE4")."</strong>: ".$reservation["reservation_email"]."<br>";
		}
		if(in_array("reservation_phone",$settingObj->getVisibleFields())) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE5")."</strong>: ".$reservation["reservation_phone"]."<br>";
		}
		
		if(in_array("reservation_message",$settingObj->getVisibleFields())) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE6")."</strong>: ".$reservation["reservation_message"]."<br>";
		}	
		if(in_array("reservation_field1",$settingObj->getVisibleFields())) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE10")."</strong>: ".$reservation["reservation_field1"]."<br>";
		}
		if(in_array("reservation_field2",$settingObj->getVisibleFields())) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE11")."</strong>: ".$reservation["reservation_field2"]."<br>";
		}
		if(in_array("reservation_field3",$settingObj->getVisibleFields())) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE12")."</strong>: ".$reservation["reservation_field3"]."<br>";
		}
		if(in_array("reservation_field4",$settingObj->getVisibleFields())) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE13")."</strong>: ".$reservation["reservation_field4"]."<br>";
		}
		$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_CALENDAR")."</strong>: ".$calendarObj->getCalendarTitle()."<br>";
		$dateToSend = strftime('%B %d %Y',strtotime($reservation["reservation_date"]));
		if($settingObj->getDateFormat() == "UK") {
			$dateToSend = strftime('%d/%m/%Y',strtotime($reservation["reservation_date"]));
		} else if($settingObj->getDateFormat() == "EU") {
			$dateToSend = strftime('%Y/%m/%d',strtotime($reservation["reservation_date"]));
		} else {
			$dateToSend = strftime('%m/%d/%Y',strtotime($reservation["reservation_date"]));
		}
		$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_DATE")."</strong>: ".$dateToSend."<br>";
		if($settingObj->getTimeFormat() == "12") {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_TIME")."</strong>: ".$reservation["reservation_time_from_ampm"]."-".$reservation["reservation_time_to_ampm"]."<br>";
		} else {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_TIME")."</strong>: ".$reservation["reservation_time_from"]."-".$reservation["reservation_time_to"]."<br>";
		}
		if($settingObj->getSlotsUnlimited() == 2) {
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_SEATS")."</strong>: ".$reservation["reservation_seats"]."<br>";
		}
		if($settingObj->getPaypalDisplayPrice() == 1) {
			$price = "";
			if(!function_exists('money_format')) {
				$price= $utilsObj->money_format('%!.2n',$reservation["reservation_price"])."&nbsp;".$settingObj->getPaypalCurrency();
			} else {
				$price= money_format('%!.2n',$reservation["reservation_price"])."&nbsp;".$settingObj->getPaypalCurrency();
			}
			$message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_PRICE")."</strong>: ".$price."<br>";
		}
	}
	
	
	
	require_once(dirname(__FILE__).'/libs/PHPMailer/class.phpmailer.php');
	
	$mail             = new PHPMailer(); // defaults to using php "mail()"
	
	$mail->CharSet = 'UTF-8';
	$body             = $message;
	@$body             = eregi_replace("[\]",'',$body);
	
	$mail->AddReplyTo($settingObj->getEmailFromReservation(),$settingObj->getNameFromReservation());
	
	$mail->SetFrom($settingObj->getEmailFromReservation(), $settingObj->getNameFromReservation());
	
	$address = $to;
	$mail->AddAddress($address, $address);
	
	$mail->Subject    = $subject;
	
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 
	
	$mail->MsgHTML($body);
	
	
	$mail->Send();
	?>
<?php
} else {
	?>
<div style="text-align:center;width:960px; margin: 100px auto 0;">
	<div style="font-size: 30px;"><?php echo $langObj->getLabel("EXPIRED_LINK"); ?></div>
    
    
    <?php
	if($settingObj->getCancelRedirect() != '') {
		?>
		<div id="redirect_link_button" style="font-size: 20px; margin-top: 20px;"><a href="<?php echo $settingObj->getCancelRedirect(); ?>"><?php echo $langObj->getLabel("CANCEL_REDIRECT"); ?></a></div>
		<?php
	} else {
		?>
		<div id="redirect_link_button" style="font-size: 20px; margin-top: 20px;"><a href="index.php"><?php echo $langObj->getLabel("CANCEL_REDIRECT"); ?></a></div>
		<?php
	}
	?>
    </div>
<?php
}
?>
</body>
</html>
