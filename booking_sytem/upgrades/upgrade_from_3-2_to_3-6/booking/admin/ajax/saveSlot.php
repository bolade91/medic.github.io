<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
$arrTimeFrom = explode(":",$_REQUEST["time_from"]);
	
if($arrTimeFrom[2]!='undefined') {
	if($arrTimeFrom[2] == 'pm') {
		//am pm Have to put it in 24 hour
		switch($arrTimeFrom[0]) {
			case '1':
				$arrTimeFrom[0] = '13';
				break;
			case '2':
				$arrTimeFrom[0] = '14';
				break;
			case '3':
				$arrTimeFrom[0] = '15';
				break;
			case '4':
				$arrTimeFrom[0] = '16';
				break;
			case '5':
				$arrTimeFrom[0] = '17';
				break;
			case '6':
				$arrTimeFrom[0] = '18';
				break;
			case '7':
				$arrTimeFrom[0] = '19';
				break;
			case '8':
				$arrTimeFrom[0] = '20';
				break;
			case '9':
				$arrTimeFrom[0] = '21';
				break;
			case '10':
				$arrTimeFrom[0] = '22';
				break;
			case '11':
				$arrTimeFrom[0] = '23';
				break;
		}
	} else if($arrTimeFrom[2] == 'am') {
		switch($arrTimeFrom[0]) {
			case '12':
				$arrTimeFrom[0] = '0';
				break;
		}
	}
	if(strlen($arrTimeFrom[0]) == 1) {
		$arrTimeFrom[0]='0'.$arrTimeFrom[0];
	}
	if(strlen($arrTimeFrom[1]) == 1) {
		$arrTimeFrom[1]='0'.$arrTimeFrom[1];
	}
} 
$timeFromString=$arrTimeFrom[0].":".$arrTimeFrom[1];
$arrTimeTo = explode(":",$_REQUEST["time_to"]);
if($arrTimeTo[2]!='undefined') {
	if($arrTimeTo[2] == 'pm') {
		//am pm Have to put it in 24 hour
		switch($arrTimeTo[0]) {
			case '1':
				$arrTimeTo[0] = '13';
				break;
			case '2':
				$arrTimeTo[0] = '14';
				break;
			case '3':
				$arrTimeTo[0] = '15';
				break;
			case '4':
				$arrTimeTo[0] = '16';
				break;
			case '5':
				$arrTimeTo[0] = '17';
				break;
			case '6':
				$arrTimeTo[0] = '18';
				break;
			case '7':
				$arrTimeTo[0] = '19';
				break;
			case '8':
				$arrTimeTo[0] = '20';
				break;
			case '9':
				$arrTimeTo[0] = '21';
				break;
			case '10':
				$arrTimeTo[0] = '22';
				break;
			case '11':
				$arrTimeTo[0] = '23';
				break;
		}
	} else if($arrTimeTo[2] == 'am') {
		switch($arrTimeTo[0]) {
			case '12':
				$arrTimeTo[0] = '0';
				break;
		}
	}
	if(strlen($arrTimeTo[0]) == 1) {
		$arrTimeTo[0]='0'.$arrTimeTo[0];
	}
	if(strlen($arrTimeTo[1]) == 1) {
		$arrTimeTo[1]='0'.$arrTimeTo[1];
	}
} 
$timeToString=$arrTimeTo[0].":".$arrTimeTo[1];
	//check if there is a slot with same date/time
    $query->prepare("SELECT * FROM booking_slots WHERE slot_date = ? AND slot_time_from = ? AND slot_id <> ?");
    $query->execute(array($_REQUEST["date"],$timeFromString.":00",$_REQUEST["item_id"]));
    $check = $query->rowCount();
	if($check >0) {
		echo 0;
	} else {
		//edit slot
		$av ="slot_av";
		if(isset($_REQUEST["av"]) && $_REQUEST["av"]!='') {
			$av = $_REQUEST["av"];
		}
		$avmax ="slot_av_max";
		if(isset($_REQUEST["avmax"]) && $_REQUEST["avmax"]!='') {
			$avmax = $_REQUEST["avmax"];
		}
		if(isset($_REQUEST["price"]) && $_REQUEST["price"]!='') {
            $query = $db->prepare("UPDATE booking_slots SET slot_date= ?, slot_time_from = ?, slot_time_to = ?,slot_special_text=?,slot_price=?,slot_av=?,slot_av_max=? WHERE slot_id=?");
            $query->execute(array($_REQUEST["date"],$timeFromString.":00",$timeToString.":00",$_REQUEST["text"],str_replace(",",".",$_REQUEST["price"])),$av,$avmax,$_REQUEST["item_id"]);
		} else {
            $query = $db->prepare("UPDATE booking_slots SET slot_date= ?, slot_time_from = ?, slot_time_to = ?,slot_special_text=?,slot_av=?,slot_av_max=? WHERE slot_id=?");
            $query->execute(array($_REQUEST["date"],$timeFromString.":00",$timeToString.":00",$_REQUEST["text"],$av,$avmax,$_REQUEST["item_id"]));

		}
        $dateQry = $db->prepare("SELECT * FROM booking_slots WHERE slot_id=?");
        $dateQry->execute(array($_REQUEST["item_id"]));
        $rows = $dateQry->fetchAll(PDO::FETCH_ASSOC);

		if($settingObj->getDateFormat() == "UK") {
			$dateToSend = strftime('%d/%m/%Y',strtotime($rows[0]["slot_date"]));
		} else if($settingObj->getDateFormat() == "EU") {
			$dateToSend = strftime('%Y/%m/%d',strtotime($rows[0]["slot_date"]));
		} else {
			$dateToSend = strftime('%m/%d/%Y',strtotime($rows[0]["slot_date"]));
		}
		echo $dateToSend;
		
	}
}


?>
