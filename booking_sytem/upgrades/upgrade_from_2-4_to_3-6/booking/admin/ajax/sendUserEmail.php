<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	
	
	$subject = $_POST["user_contact_subject"];
	$message=$_POST["user_contact_message"];
	$to=$_POST["user_contact_email"];
	
	require_once(dirname(__FILE__).'/../../libs/PHPMailer/class.phpmailer.php');

	$mail             = new PHPMailer(); // defaults to using php "mail()"
	
	$mail->CharSet = 'UTF-8';
	$body             = $message;
	@$body             = eregi_replace("[\]",'',$body);
	
	$mail->AddReplyTo($settingObj->getEmailFromReservation(),$settingObj->getNameFromReservation());
	
	$mail->SetFrom($settingObj->getEmailFromReservation(), $settingObj->getNameFromReservation());
	
	$arrAddress = explode(",",$to);
	for($i=0;$i<count($arrAddress);$i++) {		
		$mail->AddAddress($arrAddress[$i], $arrAddress[$i]);
	}
	
	$arrAddress = explode(",",$_POST["user_contact_cc"]);
	for($i=0;$i<count($arrAddress);$i++) {		
		$mail->AddCC($arrAddress[$i], $arrAddress[$i]);
	}
	
	$arrAddress = explode(",",$_POST["user_contact_bcc"]);
	for($i=0;$i<count($arrAddress);$i++) {		
		$mail->AddBCC($arrAddress[$i], $arrAddress[$i]);
	}
	
	
	$mail->Subject    = $subject;
	
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 
	
	$mail->MsgHTML($body);
	
	
	if($mail->Send()) {
	
		?>
		<script>
			window.parent.$('#contact_modal').html('<?php echo addslashes($langObj->getLabel("RESERVATION_USER_CONTACT_MESSAGE_SENT")); ?><br><input type="button" onclick="hideModal()" value="close">');
		</script>
		<?php
	} else {
		?>
		<script>
			window.parent.alert('<?php echo addslashes($langObj->getLabel("RESERVATION_USER_CONTACT_MESSAGE_ERROR")); ?>');
		</script>
		<?php
	}
}

?>
