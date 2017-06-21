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
	
	
	
	public function getHolidayRecordcount($calendar_id) {
        $query = $this->db->prepare("SELECT * FROM booking_holidays WHERE calendar_id = ?");
        $query->execute(array($calendar_id));
		return $query->rowCount();
	}
	
	

}

?>