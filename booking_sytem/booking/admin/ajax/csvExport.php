<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	$fp = fopen('reservation.csv', 'w+');
	$headerLine = $langObj->getLabel("RESERVATION_DATE_LABEL").",".$langObj->getLabel("RESERVATION_TIME_LABEL");
	if(in_array("reservation_surname",$settingObj->getVisibleFields())) { 		
		$headerLine.=",".$langObj->getLabel("RESERVATION_SURNAME_LABEL");
	}
	if(in_array("reservation_name",$settingObj->getVisibleFields())) { 		
		$headerLine.=",".$langObj->getLabel("RESERVATION_NAME_LABEL");
	}
	if(in_array("reservation_email",$settingObj->getVisibleFields())) { 		
		$headerLine.=",".$langObj->getLabel("RESERVATION_EMAIL_LABEL");
	}
	if(in_array("reservation_phone",$settingObj->getVisibleFields())) { 		
		$headerLine.=",".$langObj->getLabel("RESERVATION_PHONE_LABEL");
	}
	if(in_array("reservation_message",$settingObj->getVisibleFields())) { 		
		$headerLine.=",".$langObj->getLabel("RESERVATION_MESSAGE_LABEL");
	}
	if(in_array("reservation_field1",$settingObj->getVisibleFields())) { 		
		$headerLine.=",".$langObj->getLabel("RESERVATION_ADDITIONAL_FIELD1");
	}
	if(in_array("reservation_field2",$settingObj->getVisibleFields())) { 		
		$headerLine.=",".$langObj->getLabel("RESERVATION_ADDITIONAL_FIELD2");
	}
	if(in_array("reservation_field3",$settingObj->getVisibleFields())) { 		
		$headerLine.=",".$langObj->getLabel("RESERVATION_ADDITIONAL_FIELD3");
	}
	if(in_array("reservation_field4",$settingObj->getVisibleFields())) { 		
		$headerLine.=",".$langObj->getLabel("RESERVATION_ADDITIONAL_FIELD4");
	}
	if($settingObj->getSlotsUnlimited() == 2) {
		$headerLine.=",".$langObj->getLabel("RESERVATION_SEATS_LABEL");
	}
	$headerLine.=",".$langObj->getLabel("RESERVATION_CONFIRMED_LABEL").",".$langObj->getLabel("CANCELLED")."\r\n";
	
	fwrite($fp, $headerLine);
	
	$arrayReservations = $listObj->getReservationsList($_SESSION["qryReservationsFilterString"],$_SESSION["qryReservationsOrderString"],$_GET["calendar_id"]);
	foreach($arrayReservations as $reservationId => $reservation) {
		$confirmed = $langObj->getLabel("RESERVATION_CONFIRMED_NO");
		if($reservation["reservation_confirmed"] ==1) {
			$confirmed = $langObj->getLabel("RESERVATION_CONFIRMED_YES");
		}
		$cancelled = $langObj->getLabel("RESERVATION_CONFIRMED_NO");
		if($reservation["reservation_cancelled"] ==1) {
			$cancelled = $langObj->getLabel("RESERVATION_CONFIRMED_YES");
		}
		
		$line = $reservation["reservation_date"].",".$reservation["reservation_time"];
		if(in_array("reservation_surname",$settingObj->getVisibleFields())) { 		
			$line.=",".$reservation["reservation_surname"];
		}
		if(in_array("reservation_name",$settingObj->getVisibleFields())) { 		
			$line.=",".$reservation["reservation_name"];
		}
		if(in_array("reservation_email",$settingObj->getVisibleFields())) { 		
			$line.=",".$reservation["reservation_email"];
		}
		if(in_array("reservation_phone",$settingObj->getVisibleFields())) { 		
			$line.=",".$reservation["reservation_phone"];
		}
		if(in_array("reservation_message",$settingObj->getVisibleFields())) { 		
			$line.=",".$reservation["reservation_message"];
		}
		if(in_array("reservation_field1",$settingObj->getVisibleFields())) { 		
			$line.=",".$reservation["reservation_field1"];
		}
		if(in_array("reservation_field2",$settingObj->getVisibleFields())) { 		
			$line.=",".$reservation["reservation_field2"];
		}
		if(in_array("reservation_field3",$settingObj->getVisibleFields())) { 		
			$line.=",".$reservation["reservation_field3"];
		}
		if(in_array("reservation_field4",$settingObj->getVisibleFields())) { 		
			$line.=",".$reservation["reservation_field4"];
		}
		if($settingObj->getSlotsUnlimited() == 2) {
			$line.=",".$reservation["reservation_seats"];
		}
		$line.=",".$confirmed.",".$cancelled."\r\n";
		fwrite($fp, $line);
	}
	
	fclose($fp);
	
	
	
}
?>
