<?php
include '../common.php';
$slotsObj->setSlot($_GET["slot_id"]);
if($slotsObj->getSlotSpecialMode() == 1) {
	if($settingObj->getTimeFormat() == "12") {
		$time= date('h:i a',strtotime(substr($slotsObj->getSlotTimeFrom(),0,5)))." - ".date('h:i a',strtotime(substr($slotsObj->getSlotTimeTo(),0,5)));
	} else {
		$time= substr($slotsObj->getSlotTimeFrom(),0,5)." - ".substr($slotsObj->getSlotTimeTo(),0,5);
	}
	if($slotsObj->getSlotSpecialText() != '') {
		$time.= " - ".$slotsObj->getSlotSpecialText(); 
	}
} else if($slotsObj->getSlotSpecialMode() == 0 && $slotsObj->getSlotSpecialText() != '') {
	$time= $slotsObj->getSlotSpecialText(); 
} else {
	if($settingObj->getTimeFormat() == "12") {
		echo date('h:i a',strtotime(substr($slotsObj->getSlotTimeFrom(),0,5)))." - ".date('h:i a',strtotime(substr($slotsObj->getSlotTimeTo(),0,5)));
	} else {
		echo substr($slotsObj->getSlotTimeFrom(),0,5)." - ".substr($slotsObj->getSlotTimeTo(),0,5);
	}
}
if($settingObj->getDateFormat() == "UK") {
	$dateToSend = strftime('%d/%m/%Y',strtotime($slotsObj->getSlotDate()));
} else if($settingObj->getDateFormat() == "EU") {
	$dateToSend = strftime('%Y/%m/%d',strtotime($slotsObj->getSlotDate()));
} else {
	$dateToSend = strftime('%m/%d/%Y',strtotime($slotsObj->getSlotDate()));
}
$info_slot = $dateToSend."\r\n".$time;
echo $info_slot."$".$slotsObj->getSlotPrice();
?>