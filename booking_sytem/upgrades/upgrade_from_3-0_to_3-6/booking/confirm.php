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
if(!$reservationObj->isPassed($_GET["reservations"]) && !$reservationObj->isAdminConfirmed($_GET["reservations"]) && !$reservationObj->isCancelled($_GET["reservations"])) {
$reservationObj->confirmReservations($_GET["reservations"]);
//send reservation email to user
//get all reservations data
	$reservationObj->setReservation($listObj->getCustomerDataList($_GET["reservations"]));
	
	$to = $reservationObj->getReservationEmail();
	
	$mailObj->setMail(1);
		
	$subject = $mailObj->getMailSubject();
	//setting username in message
	$message=str_replace("[customer-name]",$reservationObj->getReservationName(),$mailObj->getMailText());
	//check if cancellation is enabled id email is 1
	if($mailObj->getMailId() == 1 && $settingObj->getReservationCancel() == "1") {
		$message.=$mailObj->getMailCancelText();
	}
	//setting reservation detail in message
	//get reservations list
	$slotsArray = $listObj->getSlotsByReservationsList($_GET["reservations"]);
	//loop through slots
	$res_details = "";
	for($i=0;$i<count($slotsArray);$i++) {
		$slotsObj->setSlot($slotsArray[$i]);
		$calendarObj->setCalendar($slotsObj->getSlotCalendarId());	
		$res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_VENUE")."</strong>: ".$calendarObj->getCalendarTitle()."<br>";
		$dateToSend = strftime('%B %d %Y',strtotime($slotsObj->getSlotDate()));
		if($settingObj->getDateFormat() == "UK") {
			$dateToSend = strftime('%d/%m/%Y',strtotime($slotsObj->getSlotDate()));
		} else if($settingObj->getDateFormat() == "EU") {
			$dateToSend = strftime('%Y/%m/%d',strtotime($slotsObj->getSlotDate()));
		} else {
			$dateToSend = strftime('%m/%d/%Y',strtotime($slotsObj->getSlotDate()));
		}
		$res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_DATE")."</strong>: ".$dateToSend."<br>";
		if($slotsObj->getSlotSpecialMode() == 1) {
			if($settingObj->getTimeFormat() == "12") {
				$res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>: ".$slotsObj->getSlotTimeFromAMPM()."-".$slotsObj->getSlotTimeToAMPM();
			} else {
				$res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>: ".$slotsObj->getSlotTimeFrom()."-".$slotsObj->getSlotTimeTo();
			}
			if($slotsObj->getSlotSpecialText()!='') {
				$res_details.=" - ".$slotsObj->getSlotSpecialText();
			}
			$res_details.="<br>";
		} else if($slotsObj->getSlotSpecialMode() == 0 && $slotsObj->getSlotSpecialText() != '') {
			$res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>:".$slotsObj->getSlotSpecialText()."<br>";
		} else {
			if($settingObj->getTimeFormat() == "12") {
				$res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>: ".$slotsObj->getSlotTimeFromAMPM()."-".$slotsObj->getSlotTimeToAMPM()."<br>";
			} else {
				$res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>: ".$slotsObj->getSlotTimeFrom()."-".$slotsObj->getSlotTimeTo()."<br>";
			}
		}
		
		$res_details.="<br><br>";
	}
	$message=str_replace("[reservation-details]",$res_details,$message);	
	
	if($settingObj->getReservationCancel() == "1") {
		$message=str_replace("[cancellation-link]","<a href='".CALENDAR_PATH."/cancel.php?reservations=".$_GET["reservations"]."'>".$langObj->getLabel("DORESERVATION_MAIL_USER_MESSAGE4")."</a>",$message);
		$message=str_replace("[cancellation-link-url]",CALENDAR_PATH."/cancel.php?reservations=".$_GET["reservations"],$message);
	}
	$message.="<br><br>".$mailObj->getMailSignature();
	
	
	
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

<div style="text-align:center;width:960px; margin: 100px auto 0;">
	<div style="font-size: 30px;"><?php echo $langObj->getLabel("CONFIRM_RESERVATION_CONFIRMED"); ?></div>
    <div style="font-size: 20px; margin-top: 20px;"><?php echo $langObj->getLabel("CONFIRM_RESERVATION_CONFIRMED_2"); ?></div>
    
    <?php
	if($settingObj->getRedirect() != '') {
		?>
		<div id="redirect_link_button" style="font-size: 20px; margin-top: 20px;"><a href="<?php echo $settingObj->getRedirect(); ?>"><?php echo $langObj->getLabel("CONFIRM_REDIRECT"); ?></a></div>
		<?php
	} else {
		?>
		<div id="redirect_link_button" style="font-size: 20px; margin-top: 20px;"><a href="index.php"><?php echo $langObj->getLabel("CONFIRM_REDIRECT"); ?></a></div>
		<?php
	}
	?>
    </div>
<?php 
} else {
?>
<div style="text-align:center;width:960px; margin: 100px auto 0;">
	<div style="font-size: 30px;"><?php echo $langObj->getLabel("EXPIRED_LINK"); ?></div>
    
    <?php
	if($settingObj->getRedirect() != '') {
		?>
		<div id="redirect_link_button" style="font-size: 20px; margin-top: 20px;"><a href="<?php echo $settingObj->getRedirect(); ?>"><?php echo $langObj->getLabel("CONFIRM_REDIRECT"); ?></a></div>
		<?php
	} else {
		?>
		<div id="redirect_link_button" style="font-size: 20px; margin-top: 20px;"><a href="index.php"><?php echo $langObj->getLabel("CONFIRM_REDIRECT"); ?></a></div>
		<?php
	}
	?>
    </div>
<?php
}
?>
    
</body>
</html>
