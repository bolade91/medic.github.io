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
	
	public function getReservationSeats() {
		return $this->reservationQry["reservation_seats"];
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
	public function getReservationConfirmed() {
		return $this->reservationQry["reservation_confirmed"];
	}
	
	public function getReservationCancelled() {
		return $this->reservationQry["reservation_cancelled"];
	}
	
	public function delReservations($listIds) {
        $this->db->query("DELETE FROM booking_reservation WHERE reservation_id IN (".$listIds.")");
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
	

}

?>
