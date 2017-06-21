<?php

class holiday {
	private $holiday_id;
	private $holidayQry;

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	public function setHoliday($id) {
		$holidayQry = $this->db->prepare("SELECT * FROM booking_holidays WHERE holiday_id=?");
        $holidayQry->execute(array($id));
        $rows = $holidayQry->fetchAll(PDO::FETCH_ASSOC);

        if(isset($rows[0])) {
            $this->holidayQry = $rows[0];
            $this->holiday_id = $rows[0]["holiday_id"];
        }

	}
	
	public function getHolidayId() {
		return $this->holiday_id;
	}
		
	public function getHolidayDate() {
		return $this->holidayQry["holiday_date"];
	}
	
	public function addHoliday($date_from,$date_to='',$calendar_id) {
		if($date_to=='') {
			//check if this day already exists
            $holidayCheck = $this->db->prepare("SELECT * FROM booking_holidays WHERE holiday_date =? AND calendar_id=?");
            $holidayCheck->execute(array($date_from,$calendar_id));

            if($holidayCheck->rowCount()>0) {
				return 0;
			} else {
                $query = $this->db->prepare("INSERT INTO booking_holidays (holiday_date,calendar_id) VALUES(?,?)");
                $query->execute(array($date_from,$calendar_id));

				$lastId = $this->db->lastInsertId();
				//check if there are reservation for that date
                $query = $this->db->prepare("SELECT * FROM booking_reservation r INNER JOIN booking_slots s ON s.slot_id = r.slot_id WHERE s.slot_date = ? AND r.calendar_id = ?");
                $query->execute(array($date_from,$calendar_id));
                $check = $query->rowCount();
				if($check>0) {
                    $qry = $this->db->prepare("UPDATE booking_slots SET slot_active = 0 WHERE slot_date=? AND calendar_id = ?");
                    $qry->execute(array($date_from,$calendar_id));
				} else {
                    $qry = $this->db->prepare("DELETE FROM booking_slots WHERE slot_date = ? AND calendar_id=?");
                    $qry->execute(array($date_from,$calendar_id));
				}
				return $lastId;
			}
		} else {
			$arrNewIds = Array();
			$datefromnum=str_replace("-","",$date_from);
			$datetonum=str_replace("-","",$date_to);
			$date=date_create($date_from);
			
			while($datefromnum<=$datetonum) {
				
				$dateformat=date_format($date, 'Y-m-d');
				//check if this day already exists
                $holidayCheck = $this->db->prepare("SELECT * FROM booking_holidays WHERE holiday_date =? AND calendar_id=?");
                $holidayCheck->execute(array($dateformat,$calendar_id));
				if($holidayCheck->rowCount()==0) {
                    $qry = $this->db->prepare("INSERT INTO booking_holidays (holiday_date,calendar_id) VALUES(?,?)");
                    $qry->execute(array($dateformat,$calendar_id));

					array_push($arrNewIds,$this->db->lastInsertId());
					//check if there are reservation for that date
                    $qry = $this->db->prepare("SELECT * FROM booking_reservation r INNER JOIN booking_slots s ON s.slot_id = r.slot_id WHERE s.slot_date = ? AND r.calendar_id = ?");
                    $qry->execute(array($dateformat,$calendar_id));
                    $check = $qry->rowCount();
					if($check>0) {
                        $query = $this->db->prepare("UPDATE booking_slots SET slot_active = 0 WHERE slot_date=? AND calendar_id =?");
                        $query->execute(array($dateformat,$calendar_id));
					} else {
                        $query = $this->db->prepare("DELETE FROM booking_slots WHERE slot_date = ? AND calendar_id=?");
                        $query->execute(array($dateformat,$calendar_id));
					}
				}
				if(function_exists("date_add")) {
					date_add($date, date_interval_create_from_date_string('1 days'));
				} else {
					date_modify($date, '+1 day');
				}
				//date_add($date, date_interval_create_from_date_string('1 day'));	
				
				$datefromnum = date_format($date,'Ymd');;
			}
			return $arrNewIds;
		}
	}
	
	public function getHolidayRecordcount($calendar_id) {
        $query = $this->db->prepare("SELECT * FROM booking_holidays WHERE calendar_id = ?");
        $query->execute($calendar_id);
		return $query->rowCount();
	}
	
	public function delHolidays($listIds) {
        $this->db->query("DELETE FROM booking_holidays WHERE holiday_id IN (".$listIds.")");
	}
	
	public function checkHolidayDate($date_from,$date_to='',$calendar_id) {
		if($date_to=='') {
            $query = $this->db->prepare("SELECT * FROM booking_reservation r INNER JOIN booking_slots s ON s.slot_id = r.slot_id WHERE s.slot_date = ? AND r.calendar_id = ?");
            $query->execute(array($date_from,$calendar_id));
            $check = $query->rowCount();
		} else {
            $query = $this->db->prepare("SELECT * FROM booking_reservation r INNER JOIN booking_slots s ON s.slot_id = r.slot_id WHERE s.slot_date >= ? AND s.slot_date <= ? AND r.calendar_id = ?");
            $query->execute(array($date_from,$date_to,$calendar_id));
            $check = $query->rowCount();
		}
		return $check;
	}

}

?>