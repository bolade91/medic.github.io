<?php

class slot {
	private $slot_id;
	private $slotQry;

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	public function setSlot($id) {
        $slotQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_id = ?");
        $slotQry->execute(array($id));
        $rows = $slotQry->fetchAll(PDO::FETCH_ASSOC);

        if(isset($rows[0])) {
            $this->slotQry = $rows[0];
            $this->slot_id = $rows[0]["slot_id"];
        }
	}
	
	public function getSlotId() {
		return $this->slot_id;
	}
	
	public function getSlotCalendarId() {
		return $this->slotQry["calendar_id"];
	}
	
	public function getSlotDate() {
		return $this->slotQry["slot_date"];
	}
	
	public function getSlotTimeFrom() {
		return $this->slotQry["slot_time_from"];
	}
	
	public function getSlotTimeTo() {
		return $this->slotQry["slot_time_to"];
	}
	
	public function getSlotTimeFromAMPM() {
		return date('h:i a',strtotime($this->slotQry["slot_time_from"]));
	}
	
	public function getSlotTimeToAMPM() {
		return date('h:i a',strtotime($this->slotQry["slot_time_to"]));
	}
	
	public function getSlotSpecialText() {
		return stripslashes($this->slotQry["slot_special_text"]);
	}
	
	public function getSlotSpecialMode() {
		return $this->slotQry["slot_special_mode"];
	}
	
	public function getSlotPrice() {
		return $this->slotQry["slot_price"];
	}

    public function getSlotDiscountPrice() {
        return $this->slotQry["slot_discount_price"];
    }

    public function getSlotPercPrice() {
        return $this->slotQry["slot_perc_price"];
    }

    public function getSlotShowPrice() {
        return $this->slotQry["slot_show_price"];
    }
	
	public function checkFutureSlots($year,$month,$day,$calendar_id) {
        $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_date > ? AND slot_active = 1 AND calendar_id=?");
        $slotsQry->execute(array($year."-".$month."-".$day,$calendar_id));
		$totRighe = 0;
		if($slotsQry->rowCount()>0) {
            $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
            foreach($rows as $row) {
                //check reservations
                $reservationQry = $this->db->query("SELECT * FROM booking_reservation WHERE slot_id='".$row["slot_id"]."' AND reservation_cancelled = 0");
                if($reservationQry->rowCount()>0) {

                } else {
                    $totRighe++;
                }
            }
			if($totRighe>0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
		
	}
	
	public function checkPastSlots($year,$month,$day,$calendar_id) {
        $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_date < ? AND slot_active = 1 AND calendar_id=?");
        $slotsQry->execute(array($year."-".$month."-".$day,$calendar_id));
		$totRighe = 0;
		if($slotsQry->rowCount()>0) {
            $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
            foreach($rows as $row) {
                //check reservations
                $reservationQry = $this->db->query("SELECT * FROM booking_reservation WHERE slot_id='".$row["slot_id"]."' AND reservation_cancelled = 0");
                if(($row["slot_date"] == date('Y-m-d') && str_replace(":","",$row["slot_time_from"])<date('His')) || $reservationQry->rowCount()>0) {

                } else {
                    $totRighe++;
                }
            }
			if($totRighe>0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}

}

?>
