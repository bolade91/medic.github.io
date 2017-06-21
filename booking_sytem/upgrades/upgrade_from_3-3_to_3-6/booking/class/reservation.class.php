<?php

class reservation {
	private $reservation_id;
	private $reservationQry;

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	public function setReservation($id) {
        $reservationQry = $this->db->prepare("SELECT * FROM booking_reservation WHERE reservation_id = ?");
        $reservationQry->execute(array($id));
        $rows = $reservationQry->fetchAll(PDO::FETCH_ASSOC);

        if(isset($rows[0])) {
            $this->reservationQry = $rows[0];
            $this->reservation_id = $rows[0]["reservation_id"];
        }
	}

    public function setReservationByMD5($id) {
        $reservationQry = $this->db->prepare("SELECT * FROM booking_reservation WHERE SHA1(CONCAT(reservation_id, slot_id)) = ?");
        $reservationQry->execute(array($id));
        $rows = $reservationQry->fetchAll(PDO::FETCH_ASSOC);

        if(isset($rows[0])) {
            $this->reservationQry = $rows[0];
            $this->reservation_id = $rows[0]["reservation_id"];
        }

    }

	public function getReservationId() {
		return $this->reservation_id;
	}
	
	public function getReservationSlotId() {
		return $this->reservationQry["slot_id"];
	}

    public function getReservationCalendarId() {
        return $this->reservationQry["calendar_id"];
    }
	
	public function getReservationName() {
		return stripslashes($this->reservationQry["reservation_name"]);
	}
	
	public function getReservationSurname() {
		return stripslashes($this->reservationQry["reservation_surname"]);
	}
	
	public function getReservationEmail() {
		return $this->reservationQry["reservation_email"];
	}
	
	public function getReservationPhone() {
		return stripslashes($this->reservationQry["reservation_phone"]);
	}
	
	public function getReservationMessage() {
		return stripslashes($this->reservationQry["reservation_message"]);
	}
	public function getReservationField1() {
		return stripslashes($this->reservationQry["reservation_field1"]);
	}
	
	public function getReservationField2() {
		return stripslashes($this->reservationQry["reservation_field2"]);
	}
	
	public function getReservationField3() {
		return stripslashes($this->reservationQry["reservation_field3"]);
	}
	
	public function getReservationField4() {
		return stripslashes($this->reservationQry["reservation_field4"]);
	}
	
	public function getReservationSeats() {
		return $this->reservationQry["reservation_seats"];
	}
	
	public function getReservationConfirmed() {
		return $this->reservationQry["reservation_confirmed"];
	}
	
	public function getReservationCancelled() {
		return $this->reservationQry["reservation_cancelled"];
	}
	
	
	public function insertReservation($settingObj,$fake = 0) {
		$listReservations="";
		for($i=0;$i<count($_POST["reservation_slot"]);$i++) {
			$seats=1;
			if(isset($_POST["reservation_seats_".$_POST["reservation_slot"][$i]])) {
				$seats=$_POST["reservation_seats_".$_POST["reservation_slot"][$i]];
			}
			//check if there are available spots for this slot only if configuration is not infinite
			if($settingObj->getSlotsUnlimited() != 1) {
                $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_id=?");
                $slotsQry->execute(array($_POST["reservation_slot"][$i]));
                $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
				$rowSlot = $rows[0];
				$avSeats = $rowSlot["slot_av"];
				$ok = 0;
                $resQry = $this->db->prepare("SELECT * FROM booking_reservation WHERE slot_id = ? AND reservation_cancelled = 0 AND reservation_fake = 0");
                $resQry->execute(array($_POST["reservation_slot"][$i]));
				if($resQry->rowCount()==0) {
					$ok = 1;
				} else {
					$totSeats = 0;
                    $rowsRes = $resQry->fetchAll(PDO::FETCH_ASSOC);
                    foreach($rowsRes as $rowRes) {
                        $totSeats += $rowRes["reservation_seats"];
                    }
					if(($totSeats+$seats)<=$avSeats) {
						$ok = 1;
					}
				
				}
			} else {
				$ok = 1;
			}
			if($ok == 1) {
                $qry = $this->db->prepare("INSERT INTO booking_reservation(slot_id,reservation_name,reservation_surname,reservation_email,reservation_phone,reservation_message,reservation_seats,reservation_field1,reservation_field2,reservation_field3,reservation_field4,calendar_id,reservation_fake) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $qry->execute(array($_POST["reservation_slot"][$i],$_POST["reservation_name"],$_POST["reservation_surname"],$_POST["reservation_email"],$_POST["reservation_phone"],$_POST["reservation_message"],$seats,$_POST["reservation_field1"],$_POST["reservation_field2"],$_POST["reservation_field3"],$_POST["reservation_field4"],$_POST["calendar_id"],$fake));

				if($listReservations == "") {
					$listReservations.="".sha1($this->db->lastInsertId().$_POST["reservation_slot"][$i])."";
				} else {
					$listReservations.=",".sha1($this->db->lastInsertId().$_POST["reservation_slot"][$i])."";
				}
			}
		}
		
		return $listReservations;
		
		
	}
	
	public function confirmReservations($listIds) {
		$arrayReservations = explode(",",$listIds);
		$listReservations = "";
		for($i=0;$i<count($arrayReservations);$i++) {
			if($listReservations=="") {
				$listReservations.="'".$arrayReservations[$i]."'";
			} else {
				$listReservations.=",'".$arrayReservations[$i]."'";
			}
		}

        $this->db->query("UPDATE booking_reservation SET reservation_confirmed = 1,reservation_fake = 0 WHERE SHA1(CONCAT(reservation_id, slot_id)) IN (".$listReservations.")");
	}

    public function unfakeReservations($listIds) {
        $arrayReservations = explode(",",$listIds);
        $listReservations = "";
        for($i=0;$i<count($arrayReservations);$i++) {
            if($listReservations=="") {
                $listReservations.="'".$arrayReservations[$i]."'";
            } else {
                $listReservations.=",'".$arrayReservations[$i]."'";
            }
        }

        $this->db->query("UPDATE booking_reservation SET reservation_fake = 0 WHERE SHA1(CONCAT(reservation_id, slot_id)) IN (".$listReservations.")");
    }
	
	public function cancelReservations($listIds) {
		$arrayReservations = explode(",",$listIds);
		$listReservations = "";
		for($i=0;$i<count($arrayReservations);$i++) {
			if($listReservations=="") {
				$listReservations.="'".$arrayReservations[$i]."'";
			} else {
				$listReservations.=",'".$arrayReservations[$i]."'";
			}
		}
        $this->db->query("UPDATE booking_reservation SET reservation_cancelled = 1, reservation_confirmed = 0 WHERE SHA1(CONCAT(reservation_id, slot_id)) IN (".$listReservations.")");
        $checkCalendar = $this->db->query("SELECT * FROM booking_reservation WHERE SHA1(CONCAT(reservation_id, slot_id)) IN (".$listReservations.")");
		$calendar_id = 0;
		if($checkCalendar->rowCount()>0) {
            $rows = $checkCalendar->fetchAll(PDO::FETCH_ASSOC);
			$calendar_id=$rows[0]["calendar_id"];
		}
		return $calendar_id;
	}
	
	public function deleteReservations($listIds) {
		
		$arrayReservations = explode(",",$listIds);
		$listReservations = "";
		for($i=0;$i<count($arrayReservations);$i++) {
			if($listReservations=="") {
				$listReservations.="'".$arrayReservations[$i]."'";
			} else {
				$listReservations.=",'".$arrayReservations[$i]."'";
			}
		}
        $this->db->query("DELETE FROM booking_reservation WHERE SHA1(CONCAT(reservation_id, slot_id)) IN (".$listReservations.")");
	}
	
	public function checkReservationPaypalPaid($listIds) {
        $result = 0;
        $count = 0;
		$arrayReservations = explode(",",$listIds);
		for($i=0;$i<count($arrayReservations);$i++) {
            $checkQry = $this->db->prepare("SELECT * FROM booking_reservation WHERE SHA1(CONCAT(reservation_id, slot_id)) = ? AND reservation_confirmed = 1 AND reservation_fake = 0");
            $checkQry->execute(array($arrayReservations[$i]));

			if($checkQry->rowCount()>0) {
				$count++;
			}
		}
		
		if($count == count($arrayReservations)) {
			$result = 1;
		}
		return $result; 
	}
	public function isPassed($listIds) {
		
		$arrayReservations = explode(",",$listIds);
		$result = false;
		$listReservations = "";
		for($i=0;$i<count($arrayReservations);$i++) {
            $reservationQry = $this->db->prepare("SELECT s.* FROM booking_reservation r INNER JOIN booking_slots s ON s.slot_id = r.slot_id WHERE SHA1(CONCAT(r.reservation_id, r.slot_id)) = ?");
            $reservationQry->execute(array($arrayReservations[$i]));
            $rows = $reservationQry->fetchAll(PDO::FETCH_ASSOC);
			$reservationRow = $rows[0];
			$resDate = str_replace("-","",$reservationRow["slot_date"]).str_replace(":","",$reservationRow["slot_time_from"]);
			if($resDate<date('YmdHis')) {
				$result = true;
			} 
		}
		
		return $result;
		
	}
	
	public function isAdminConfirmed($listIds) {
		
		$arrayReservations = explode(",",$listIds);
		$result = false;
		$listReservations = "";
		for($i=0;$i<count($arrayReservations);$i++) {
            $reservationQry = $this->db->prepare("SELECT * FROM booking_reservation WHERE SHA1(CONCAT(reservation_id, slot_id)) = ?");
            $reservationQry->execute(array($arrayReservations[$i]));
            $rows = $reservationQry->fetchAll(PDO::FETCH_ASSOC);
            $reservationRow = $rows[0];
			if($reservationRow["admin_confirmed_cancelled"] == 1) {
				$result = true;
			}
		}
		return $result;
		
	}

    public function isCancelled($listIds) {

        $arrayReservations = explode(",",$listIds);
        $result = false;
        $listReservations = "";
        for($i=0;$i<count($arrayReservations);$i++) {
            $reservationQry = $this->db->prepare("SELECT * FROM booking_reservation WHERE SHA1(CONCAT(reservation_id, slot_id)) = ?");
            $reservationQry->execute(array($arrayReservations[$i]));
            $rows = $reservationQry->fetchAll(PDO::FETCH_ASSOC);
            $reservationRow = $rows[0];
            if($reservationRow["reservation_cancelled"] == 1) {
                $result = true;
            }
        }
        return $result;
    }
	
	public function getReservationsDetails($listIds) {
		$arrayReservations = explode(",",$listIds);
		$listReservations = "";
		for($i=0;$i<count($arrayReservations);$i++) {
			if($listReservations=="") {
				$listReservations.="'".$arrayReservations[$i]."'";
			} else {
				$listReservations.=",'".$arrayReservations[$i]."'";
			}
		}
		$arrayReservations = Array();
        $reservationsQry = $this->db->query("SELECT r.*,s.*,s.calendar_id as res_calendar, DATE_FORMAT(slot_time_from,'%I:%i %p') as slot_time_from_ampm, DATE_FORMAT(slot_time_to,'%I:%i %p') as slot_time_to_ampm FROM booking_reservation r INNER JOIN booking_slots s ON s.slot_id=r.slot_id WHERE SHA1(CONCAT(r.reservation_id, r.slot_id)) IN (".$listReservations.") ORDER BY s.slot_date, s.slot_time_from");
        $rows = $reservationsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $reservationRow) {
            $arrayReservations[$reservationRow["reservation_id"]] = Array();
            $arrayReservations[$reservationRow["reservation_id"]]["calendar_id"] = $reservationRow["res_calendar"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_date"] = $reservationRow["slot_date"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_time_from"] = $reservationRow["slot_time_from"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_time_to"] = $reservationRow["slot_time_to"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_time_from_ampm"] = $reservationRow["slot_time_from_ampm"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_time_to_ampm"] = $reservationRow["slot_time_to_ampm"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_seats"] = $reservationRow["reservation_seats"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_price"] = $reservationRow["slot_price"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_surname"] = stripslashes($reservationRow["reservation_surname"]);
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_name"] = stripslashes($reservationRow["reservation_name"]);
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_email"] = $reservationRow["reservation_email"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_message"] = $reservationRow["reservation_message"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_phone"] = $reservationRow["reservation_phone"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_field1"] = $reservationRow["reservation_field1"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_field2"] = $reservationRow["reservation_field2"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_field3"] = $reservationRow["reservation_field3"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_field4"] = $reservationRow["reservation_field4"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_confirmed"] = $reservationRow["reservation_confirmed"];
            $arrayReservations[$reservationRow["reservation_id"]]["reservation_cancelled"] = $reservationRow["reservation_cancelled"];
            $arrayReservations[$reservationRow["reservation_id"]]["slot_active"] = $reservationRow["slot_active"];
        }
		return $arrayReservations;
		
	}
	

}

?>
