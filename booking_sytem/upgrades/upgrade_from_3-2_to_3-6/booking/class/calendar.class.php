<?php

class calendar {
	private $calendar_id;
	private $calendarQry;

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	public function setCalendar($id) {
        $calendarQry = $this->db->prepare("SELECT * FROM booking_calendars WHERE calendar_id = ?");
        $calendarQry->execute(array($id));
        $rows = $calendarQry->fetchAll(PDO::FETCH_ASSOC);

        if(isset($rows[0])) {
            $this->calendarQry = $rows[0];
            $this->calendar_id = $rows[0]["calendar_id"];
        }
	}
	
	public function getCalendarId() {
		return $this->calendar_id;
	}
	public function getCalendarCategoryId() {
		return stripslashes($this->calendarQry["category_id"]);
	}
	
	public function getCalendarTitle() {
		return stripslashes($this->calendarQry["calendar_title"]);
	}
	
	public function getCalendarEmail() {
		return stripslashes($this->calendarQry["calendar_email"]);
	}
	
	public function getCalendarActive() {
		return $this->calendarQry["calendar_active"];
	}
	
	public function getCalendarRecordcount() {
        $query = $this->db->query("SELECT * FROM booking_calendars");
		return $query->rowCount();
	}
	
	public function getDefaultCalendar($category_id) {
        $calendarQry = $this->db->prepare("SELECT * FROM booking_calendars WHERE calendar_order = 0 AND calendar_active = 1 AND category_id=?");
        $calendarQry->execute(array($category_id));

		if($calendarQry->rowCount() > 0) {
            $rows = $calendarQry->fetchAll(PDO::FETCH_ASSOC);
            $calendarRow = $rows[0];
			$this->setCalendar($calendarRow["calendar_id"]);
			return true;
		} else {
			return false;
		}
	}
	
	public function getFirstFilledMonth($calendar_id) {
		$returnvalue=date("Y,m,d");
		$arrDate = explode(",",$returnvalue);
		$month = (intval($arrDate[1])-1);
		$returnvalue = $arrDate[0].",".$month.",".$arrDate[2];
        $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_date >= NOW() AND calendar_id = ? AND slot_active = 1 ORDER BY slot_date ASC LIMIT 1");
        $slotsQry->execute(array($calendar_id));
		
		if($calendar_id!= 0 && $calendar_id != '' && $slotsQry->rowCount()>0) {
            $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
            $rowSlot = $rows[0];
			$arrDate = explode("-",$rowSlot["slot_date"]);
			$month = (intval($arrDate[1])-1);
			$returnvalue = $arrDate[0].",".$month.",".$arrDate[2];
			
		}
		return $returnvalue;
	}


}

?>
