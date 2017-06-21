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
	
	public function getCalendarOrder() {
		return $this->calendarQry["calendar_order"];
	}
	
	public function publishCalendars($listIds) {
        $this->db->query("UPDATE booking_calendars SET calendar_active = 1 WHERE calendar_id IN (".$listIds.")");
	}
	
	public function unpublishCalendars($listIds) {
        $this->db->query("UPDATE booking_calendars SET calendar_active = 0 WHERE calendar_id IN (".$listIds.")");
	}
	
	public function delCalendars($listIds) {
		//loop on calendars to see if there is a default one here
		$category_id = 0;
		$default = 0;
        $calendarsQry = $this->db->query("SELECT * FROM booking_calendars WHERE calendar_id IN (".$listIds.")");
        $rows = $calendarsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $category_id=$row["category_id"];
            if($row["calendar_order"] == 0) {
                $default = 1;
            }
        }
		$this->db->query("DELETE FROM booking_calendars WHERE calendar_id IN (".$listIds.")");
		//delete holidays
        $this->db->query("DELETE FROM booking_holidays WHERE calendar_id IN (".$listIds.")");
		//check for reservations, if any disable slots, otherwise del slots
        $slotsQry = $this->db->query("SELECT * FROM booking_slots WHERE calendar_id IN (".$listIds.")");
        $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $query = $this->db->query("SELECT * FROM booking_reservation WHERE slot_id ='".$row["slot_id"]."'");
            $numRes = $query->rowCount();

            if($numRes>0) {
                $this->db->query("UPDATE booking_slots SET slot_active = 0 WHERE slot_id  =".$row["slot_id"]);
            } else {
                $this->db->query("DELETE FROM booking_slots  WHERE slot_id =".$row["slot_id"]);
            }
        }

		//set a new default calendar if the default one has been deleted
		if($default == 1) {
            $this->db->query("UPDATE booking_calendars SET calendar_order = 0 WHERE calendar_order != 0 AND category_id = ".$category_id." ORDER BY calendar_order ASC LIMIT 1");
		}
		 
		
	}
	
	public function addCalendar() {
		$newOrder = 0;
		//check order of last calendar
        $calOrderQry = $this->db->prepare("SELECT calendar_order as max FROM booking_calendars WHERE category_id=? ORDER BY calendar_order DESC LIMIT 1");
        $calOrderQry->execute(array($_POST["category_id"]));

		if($calOrderQry->rowCount()>0) {
            $rows = $calOrderQry->fetchAll(PDO::FETCH_ASSOC);
			$newOrder=$rows[0]["max"]+1;
		}
        $query = $this->db->prepare("INSERT INTO booking_calendars (category_id,calendar_title,calendar_email,calendar_order,calendar_active) VALUES(?,?,?,?,?)");
        $query->execute(array($_POST["category_id"],$_POST["calendar_title"],$_POST["calendar_email"],$newOrder,0));

		$calendar_id=$this->db->lastInsertId();
		return $calendar_id;
	}
	
	public function updateCalendar() {
		$calendar_id = $_POST["calendar_id"];
		//check if the category has changed
		$this->setCalendar($calendar_id);
		$newOrder=0;
		//update calendars order
        $calOrderQry = $this->db->prepare("SELECT calendar_order as max FROM booking_calendars WHERE category_id=? ORDER BY calendar_order DESC LIMIT 1");
        $calOrderQry->execute(array($_POST["category_id"]));

		if($calOrderQry->rowCount()>0) {
            $rows = $calOrderQry->fetchAll(PDO::FETCH_ASSOC);
			$newOrder=$rows[0]["max"]+1;
		}
		if($this->getCalendarCategoryId() != $_POST["category_id"]) {
			$query = $this->db->prepare("UPDATE booking_calendars SET calendar_order = calendar_order -1 WHERE calendar_order > ? AND calendar_id <> ? AND category_id = ?");
            $query->execute(array($this->getCalendarOrder(),$calendar_id,$this->getCalendarCategoryId()));
			
		}
        $query = $this->db->prepare("UPDATE booking_calendars SET calendar_title=?,calendar_email=?, category_id=?, calendar_order = ? WHERE calendar_id=?");
        $query->execute(array($_POST["calendar_title"],$_POST["calendar_email"],$_POST["category_id"],$newOrder,$_POST["calendar_id"]));

	}
	
	public function getCalendarRecordcount() {
        $query = $this->db->query("SELECT * FROM booking_calendars");
		return $query->rowCount();
	}
	
	public function setDefaultCalendar($calendar_id,$category_id) {
        $query = $this->db->prepare("UPDATE booking_calendars SET calendar_order = 0, calendar_active = 1 WHERE calendar_id=? AND category_id=?");
        $query->execute(array($calendar_id,$category_id));

        $query = $this->db->prepare("UPDATE booking_calendars SET calendar_order = calendar_order +1 WHERE calendar_id <> ? AND category_id=?");
        $query->execute(array($calendar_id,$category_id));
	}
	
	public function duplicateCalendars($listIds) {
		$newOrder = 0;
		//check order of last calendar
        $calOrderQry = $this->db->query("SELECT calendar_order as max FROM booking_calendars ORDER BY calendar_order DESC LIMIT 1");
        if($calOrderQry->rowCount()>0) {
            $rows = $calOrderQry->fetchAll(PDO::FETCH_ASSOC);
            $newOrder=$rows[0]["max"]+1;
		}
        $query = $this->db->query("SELECT * FROM booking_calendars WHERE calendar_id IN (".$listIds.")");
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $qry = $this->db->prepare("INSERT INTO booking_calendars (category_id,calendar_title,calendar_order,calendar_active) VALUES(?,?,?,?)");
            $qry->execute(array($row["category_id"],"duplicate of ".$row["calendar_title"],$newOrder,0));
            $last_id = $this->db->lastInsertId();

            //duplicate slots
            $this->db->query("INSERT INTO booking_slots(slot_special_text,slot_special_mode,slot_date,slot_time_from,slot_time_to,slot_active,calendar_id) SELECT slot_special_text,slot_special_mode,slot_date,slot_time_from,slot_time_to,slot_active, '".$last_id."' FROM booking_slots WHERE calendar_id = ".$row["calendar_id"]." ORDER BY slot_date,slot_time_from");

            //duplicate holidays
            $this->db->query("INSERT INTO booking_holidays(holiday_date,calendar_id) SELECT holiday_date, '".$last_id."' FROM booking_holidays WHERE calendar_id = ".$row["calendar_id"]." ORDER BY holiday_date");
        }

	}

}

?>
