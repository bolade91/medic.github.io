<?php
class lists {

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	public function getTimezonesList() {
		$arrayTimezones = Array();
        $timezonesQry = $this->db->query("SELECT * FROM booking_timezones ORDER BY timezone_name");
        $rows = $timezonesQry->fetchAll(PDO::FETCH_ASSOC);
		foreach($rows as $row) {
            $arrayTimezones[$row["timezone_id"]] = Array();
            $arrayTimezones[$row["timezone_id"]]["timezone_name"] = $row["timezone_name"];
            $arrayTimezones[$row["timezone_id"]]["timezone_value"] = $row["timezone_value"];
        }
		return $arrayTimezones;
	}	
	
	public function getHolidaysList($order_by,$calendar_id) {
		$arrayHolidays = Array();
        $holidaysQry = $this->db->prepare("SELECT * FROM booking_holidays WHERE calendar_id = ? ".$order_by);
        $holidaysQry->execute(array($calendar_id));
        $rows = $holidaysQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $arrayHolidays[$row["holiday_id"]] = Array();
            $arrayHolidays[$row["holiday_id"]]["holiday_date"] = $row["holiday_date"];
        }
		return $arrayHolidays;
	}	
	
	public function getSlotsHoursList($calendar_id) {
		$arraySlots = Array();
        $slotsQry = $this->db->prepare("SELECT DISTINCT slot_time_from FROM booking_slots WHERE slot_date >= NOW() AND slot_active = 1 AND calendar_id = ? ORDER BY slot_time_from");
        $slotsQry->execute(array($calendar_id));
        $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            array_push($arraySlots,$row["slot_time_from"]);
        }
		return $arraySlots;
	}	
	
	public function getSlotsList($filter,$order_by,$calendar_id) {
		$arraySlots = Array();
        $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_active = 1 AND calendar_id = ? ".$filter." ".$order_by);
        $slotsQry->execute(array($calendar_id));
        $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $arraySlots[$row["slot_id"]] = Array();
            $arraySlots[$row["slot_id"]]["slot_date"] = $row["slot_date"];
            $arraySlots[$row["slot_id"]]["slot_time_from"] = $row["slot_time_from"];
            $arraySlots[$row["slot_id"]]["slot_special_text"] = stripslashes($row["slot_special_text"]);
            $arraySlots[$row["slot_id"]]["slot_special_mode"] = $row["slot_special_mode"];
            $query = $this->db->query("SELECT * FROM booking_reservation WHERE slot_id = '".$row["slot_id"]."' AND reservation_cancelled = 0 AND reservation_fake = 0");
            $reservation = $query->rowCount();
            if($reservation == 0) {
                $reservation = "NO";
            } else {
                $reservation = "YES";
            }
            $arraySlots[$row["slot_id"]]["slot_reservation"] = $reservation;
        }
		return $arraySlots;
	}	
	
	public function getReservationsList($filter,$order_by,$calendar_id) {
		$arrayReservations = Array();
        $reservationsQry = $this->db->prepare("SELECT * FROM booking_reservation r INNER JOIN booking_slots s ON s.slot_id=r.slot_id WHERE r.calendar_id = ? AND s.calendar_id = ? AND r.reservation_fake = 0 ".$filter." ".$order_by);
        $reservationsQry->execute(array($calendar_id,$calendar_id));
        $rows = $reservationsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $arrayReservations[$row["reservation_id"]] = Array();
            $arrayReservations[$row["reservation_id"]]["reservation_date"] = $row["slot_date"];
            $arrayReservations[$row["reservation_id"]]["reservation_time"] = $row["slot_time_from"];
            $arrayReservations[$row["reservation_id"]]["reservation_surname"] = stripslashes($row["reservation_surname"]);
            $arrayReservations[$row["reservation_id"]]["reservation_name"] = stripslashes($row["reservation_name"]);
            $arrayReservations[$row["reservation_id"]]["reservation_email"] = $row["reservation_email"];
            $arrayReservations[$row["reservation_id"]]["reservation_confirmed"] = $row["reservation_confirmed"];
            $arrayReservations[$row["reservation_id"]]["reservation_cancelled"] = $row["reservation_cancelled"];
            $arrayReservations[$row["reservation_id"]]["slot_active"] = $row["slot_active"];
        }
		return $arrayReservations;
	}	
	
	public function getCalendarsList($order_by,$category_id=0) {
		$arrayCalendars = Array();
		if($category_id>0) {
            $calendarsQry = $this->db->prepare("SELECT * FROM booking_calendars WHERE category_id=? AND calendar_active = 1 ".$order_by);
            $calendarsQry->execute(array($category_id));
		} else {
            $calendarsQry = $this->db->query("SELECT * FROM booking_calendars WHERE calendar_active = 1 ".$order_by);
		}
        $rows = $calendarsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $arrayCalendars[$row["calendar_id"]] = Array();
            $arrayCalendars[$row["calendar_id"]]["calendar_title"] = stripslashes($row["calendar_title"]);
            $arrayCalendars[$row["calendar_id"]]["calendar_active"] = $row["calendar_active"];
            $arrayCalendars[$row["calendar_id"]]["calendar_order"] = $row["calendar_order"];
        }
		return $arrayCalendars;
	}
	
	public function getCategoriesList($order_by) {
		$arrayCategories = Array();
        $categoriesQry = $this->db->query("SELECT * FROM booking_categories WHERE category_active = 1 ".$order_by);
        $rows = $categoriesQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $arrayCategories[$row["category_id"]] = Array();
            $arrayCategories[$row["category_id"]]["category_name"] = stripslashes($row["category_name"]);
            $arrayCategories[$row["category_id"]]["category_active"] = $row["category_active"];
        }
		return $arrayCategories;
	}
	
	public function getMonthCalendar($month,$year,$weekday_format="N") {
		$arrayMonth=Array();
		$date = mktime(0,0,0,$month,1,$year); 
		for($n=1;$n <= date('t',$date);$n++){
			$arrayMonth[$n] = Array();
			$arrayMonth[$n]["dayofweek"] = date($weekday_format,mktime(0,0,0,$month,$n,$year));
			$arrayMonth[$n]["daynum"] = date('d',mktime(0,0,0,$month,$n,$year));
			$arrayMonth[$n]["monthnum"] = date('m',mktime(0,0,0,$month,$n,$year));
			$arrayMonth[$n]["yearnum"] = date('Y',mktime(0,0,0,$month,$n,$year));
		}
		return $arrayMonth;
	}
	
	public function getSlotsPerDay($year,$month,$daynum, $calendar_id,$settingObj) {
		if(strlen($month) == 1) {
			$month="0".$month;
		}
		if(strlen($daynum) == 1) {
			$daynum="0".$daynum;
		}
		if($year."-".$month."-".$daynum == date('Y-m-d')) {
            $slotsQry = $this->db->prepare("SELECT SUM(s.slot_av) AS av_seats,s.* FROM booking_slots s WHERE s.slot_active=1 AND s.slot_date = ?  AND REPLACE(s.slot_time_from,':','') >= DATE_FORMAT(NOW(),'%H%i%s') AND s.calendar_id=? GROUP BY s.slot_id");
            $slotsQry->execute(array($year."-".$month."-".$daynum,$calendar_id));

		} else {
            $slotsQry = $this->db->prepare("SELECT SUM(s.slot_av) AS av_seats,s.* FROM booking_slots s WHERE s.slot_active = 1 AND s.slot_date = ?  AND s.calendar_id=? GROUP BY s.slot_id");
            $slotsQry->execute(array($year."-".$month."-".$daynum,$calendar_id));
			
		}
		
		$tot = $slotsQry->rowCount();
		if($tot == 0) {
			//it's not soldout
			return -1;
		} else {
			if($settingObj->getSlotsUnlimited() != 1 && $settingObj->getShowSlotsSeats() == 0) {
                $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
                foreach($rows as $row) {
                    $reservationQry = $this->db->query("SELECT SUM(reservation_seats) as res FROM booking_reservation WHERE slot_id='".$row["slot_id"]."' AND reservation_cancelled = 0 AND reservation_fake = 0 GROUP BY slot_id");
                    $rowsRes = $reservationQry->fetchAll(PDO::FETCH_ASSOC);
                    if(($reservationQry->rowCount()>0 && $rowsRes[0]["res"] == $row["slot_av"]) || ($reservationQry->rowCount()>0 && $settingObj->getSlotsUnlimited() == 0)) {
                        $tot--;
                    }
                }
			} else if($settingObj->getSlotsUnlimited() == 2 && $settingObj->getShowSlotsSeats() == 1) {
				$tot=0;
                $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
                foreach($rows as $row) {
                    if($row["av_seats"] == 0) {
                        $tot++;
                    } else {
                        $tot = $tot+$row["av_seats"];
                    }
                    $reservationQry = $this->db->query("SELECT SUM(reservation_seats) as res FROM booking_reservation WHERE slot_id='".$row["slot_id"]."' AND reservation_cancelled = 0 AND reservation_fake = 0 GROUP BY slot_id");
                    if($reservationQry->rowCount()>0) {
                        $rowsRes = $reservationQry->fetchAll(PDO::FETCH_ASSOC);
                        $tot = $tot-$rowsRes[0]["res"];
                    }
                }
				
			}
			return $tot;
		}
	}
	
	public function getSlotsPerDayList($year,$month,$day,$calendar_id,$settingObj) {
		
		$arraySlots=Array();
		if(strlen($month) == 1) {
			$month="0".$month;
		}
		if(strlen($day) == 1) {
			$day="0".$day;
		}
		if($year."-".$month."-".$day == date('Y-m-d')) {
		    $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_active=1 AND slot_date = ? AND REPLACE(slot_time_from,':','') >= DATE_FORMAT(NOW(),'%H%i%s') AND calendar_id=? ORDER BY slot_time_from");
            $slotsQry->execute(array($year."-".$month."-".$day,$calendar_id));
		} else {
            $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_active = 1 AND slot_date = ? AND calendar_id=? ORDER BY slot_time_from");
            $slotsQry->execute(array($year."-".$month."-".$day,$calendar_id));
		}
        $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $slotRow) {
            if($settingObj->getSlotsUnlimited() == 0 && $settingObj->getShowBookedSlots() == 0) {
                $reservationQry = $this->db->query("SELECT * FROM booking_reservation WHERE slot_id='".$slotRow["slot_id"]."' AND reservation_cancelled = 0 AND reservation_fake = 0");
                if($reservationQry->rowCount()==0) {
                    $arraySlots[$slotRow["slot_id"]] = Array();
                    $arraySlots[$slotRow["slot_id"]]["slot_time_from"] = $slotRow["slot_time_from"];
                    $arraySlots[$slotRow["slot_id"]]["slot_time_to"] = $slotRow["slot_time_to"];
                    $arraySlots[$slotRow["slot_id"]]["slot_special_text"] = stripslashes($slotRow["slot_special_text"]);
                    $arraySlots[$slotRow["slot_id"]]["slot_special_mode"] = $slotRow["slot_special_mode"];
                    $arraySlots[$slotRow["slot_id"]]["slot_price"] = $slotRow["slot_price"];
                    $arraySlots[$slotRow["slot_id"]]["slot_discount_price"] = $slotRow["slot_discount_price"];
                    $arraySlots[$slotRow["slot_id"]]["slot_perc_price"] = $slotRow["slot_perc_price"];
                    $arraySlots[$slotRow["slot_id"]]["slot_show_price"] = $slotRow["slot_show_price"];
                    $arraySlots[$slotRow["slot_id"]]["slot_av"] = $slotRow["slot_av"];
                    $arraySlots[$slotRow["slot_id"]]["booked"] = 0;
                }
            } else if($settingObj->getSlotsUnlimited() == 1) {
                $arraySlots[$slotRow["slot_id"]] = Array();
                $arraySlots[$slotRow["slot_id"]]["slot_time_from"] = $slotRow["slot_time_from"];
                $arraySlots[$slotRow["slot_id"]]["slot_time_to"] = $slotRow["slot_time_to"];
                $arraySlots[$slotRow["slot_id"]]["slot_special_text"] = stripslashes($slotRow["slot_special_text"]);
                $arraySlots[$slotRow["slot_id"]]["slot_special_mode"] = $slotRow["slot_special_mode"];
                $arraySlots[$slotRow["slot_id"]]["slot_price"] = $slotRow["slot_price"];
                $arraySlots[$slotRow["slot_id"]]["slot_discount_price"] = $slotRow["slot_discount_price"];
                $arraySlots[$slotRow["slot_id"]]["slot_perc_price"] = $slotRow["slot_perc_price"];
                $arraySlots[$slotRow["slot_id"]]["slot_show_price"] = $slotRow["slot_show_price"];
                $arraySlots[$slotRow["slot_id"]]["slot_av"] = $slotRow["slot_av"];
                $arraySlots[$slotRow["slot_id"]]["booked"] = 0;
            } else if($settingObj->getSlotsUnlimited() == 0 && $settingObj->getShowBookedSlots() == 1) {
                $reservationQry = $this->db->query("SELECT * FROM booking_reservation WHERE slot_id='".$slotRow["slot_id"]."' AND reservation_cancelled = 0 AND reservation_fake = 0");
                if($reservationQry->rowCount()>0) {
                    $booked=1;
                } else {
                    $booked = 0;
                }
                $arraySlots[$slotRow["slot_id"]] = Array();
                $arraySlots[$slotRow["slot_id"]]["slot_time_from"] = $slotRow["slot_time_from"];
                $arraySlots[$slotRow["slot_id"]]["slot_time_to"] = $slotRow["slot_time_to"];
                $arraySlots[$slotRow["slot_id"]]["slot_special_text"] = stripslashes($slotRow["slot_special_text"]);
                $arraySlots[$slotRow["slot_id"]]["slot_special_mode"] = $slotRow["slot_special_mode"];
                $arraySlots[$slotRow["slot_id"]]["slot_price"] = $slotRow["slot_price"];
                $arraySlots[$slotRow["slot_id"]]["slot_discount_price"] = $slotRow["slot_discount_price"];
                $arraySlots[$slotRow["slot_id"]]["slot_perc_price"] = $slotRow["slot_perc_price"];
                $arraySlots[$slotRow["slot_id"]]["slot_show_price"] = $slotRow["slot_show_price"];
                $arraySlots[$slotRow["slot_id"]]["slot_av"] = $slotRow["slot_av"];
                $arraySlots[$slotRow["slot_id"]]["booked"] = $booked;
            } else if($settingObj->getSlotsUnlimited() == 2) {
                $booked = 0;
                $reservationQry = $this->db->query("SELECT SUM(reservation_seats) as seats FROM booking_reservation WHERE slot_id='".$slotRow["slot_id"]."' AND reservation_cancelled = 0 AND reservation_fake = 0 GROUP BY slot_id");
                $rowsRes = $reservationQry->fetchAll(PDO::FETCH_ASSOC);
                if($settingObj->getShowBookedSlots() == 1 && $reservationQry->rowCount()>0 && $rowsRes[0]["seats"] == $slotRow["slot_av"]) {
                    $booked=1;
                    $slot_av = 0;
                    $arraySlots[$slotRow["slot_id"]] = Array();
                    $arraySlots[$slotRow["slot_id"]]["slot_time_from"] = $slotRow["slot_time_from"];
                    $arraySlots[$slotRow["slot_id"]]["slot_time_to"] = $slotRow["slot_time_to"];
                    $arraySlots[$slotRow["slot_id"]]["slot_special_text"] = stripslashes($slotRow["slot_special_text"]);
                    $arraySlots[$slotRow["slot_id"]]["slot_special_mode"] = $slotRow["slot_special_mode"];
                    $arraySlots[$slotRow["slot_id"]]["slot_price"] = $slotRow["slot_price"];
                    $arraySlots[$slotRow["slot_id"]]["slot_discount_price"] = $slotRow["slot_discount_price"];
                    $arraySlots[$slotRow["slot_id"]]["slot_perc_price"] = $slotRow["slot_perc_price"];
                    $arraySlots[$slotRow["slot_id"]]["slot_show_price"] = $slotRow["slot_show_price"];
                    $arraySlots[$slotRow["slot_id"]]["slot_av"] = $slot_av;
                    $arraySlots[$slotRow["slot_id"]]["slot_av_max"] = $slot_av;
                    $arraySlots[$slotRow["slot_id"]]["booked"] = $booked;

                } else {
                    $booked=0;
                    if($reservationQry->rowCount()>0 && $rowsRes[0]["seats"] == $slotRow["slot_av"]) {
                    } else if($reservationQry->rowCount()>0) {
                        $slot_av = $slotRow["slot_av"]-$rowsRes[0]["seats"];
                        $slot_av_max=$slotRow["slot_av_max"];
                        if($slot_av_max>$slot_av) {
                            $slot_av_max = $slot_av;
                        }
                        $arraySlots[$slotRow["slot_id"]] = Array();
                        $arraySlots[$slotRow["slot_id"]]["slot_time_from"] = $slotRow["slot_time_from"];
                        $arraySlots[$slotRow["slot_id"]]["slot_time_to"] = $slotRow["slot_time_to"];
                        $arraySlots[$slotRow["slot_id"]]["slot_special_text"] = stripslashes($slotRow["slot_special_text"]);
                        $arraySlots[$slotRow["slot_id"]]["slot_special_mode"] = $slotRow["slot_special_mode"];
                        $arraySlots[$slotRow["slot_id"]]["slot_price"] = $slotRow["slot_price"];
                        $arraySlots[$slotRow["slot_id"]]["slot_discount_price"] = $slotRow["slot_discount_price"];
                        $arraySlots[$slotRow["slot_id"]]["slot_perc_price"] = $slotRow["slot_perc_price"];
                        $arraySlots[$slotRow["slot_id"]]["slot_show_price"] = $slotRow["slot_show_price"];
                        $arraySlots[$slotRow["slot_id"]]["slot_av"] = $slot_av;
                        $arraySlots[$slotRow["slot_id"]]["slot_av_max"] = $slot_av_max;
                        $arraySlots[$slotRow["slot_id"]]["booked"] = $booked;
                    } else {
                        $slot_av = $slotRow["slot_av"];
                        $slot_av_max=$slotRow["slot_av_max"];
                        if($slot_av_max>$slot_av) {
                            $slot_av_max = $slot_av;
                        }
                        $arraySlots[$slotRow["slot_id"]] = Array();
                        $arraySlots[$slotRow["slot_id"]]["slot_time_from"] = $slotRow["slot_time_from"];
                        $arraySlots[$slotRow["slot_id"]]["slot_time_to"] = $slotRow["slot_time_to"];
                        $arraySlots[$slotRow["slot_id"]]["slot_special_text"] = stripslashes($slotRow["slot_special_text"]);
                        $arraySlots[$slotRow["slot_id"]]["slot_special_mode"] = $slotRow["slot_special_mode"];
                        $arraySlots[$slotRow["slot_id"]]["slot_price"] = $slotRow["slot_price"];
                        $arraySlots[$slotRow["slot_id"]]["slot_discount_price"] = $slotRow["slot_discount_price"];
                        $arraySlots[$slotRow["slot_id"]]["slot_perc_price"] = $slotRow["slot_perc_price"];
                        $arraySlots[$slotRow["slot_id"]]["slot_show_price"] = $slotRow["slot_show_price"];
                        $arraySlots[$slotRow["slot_id"]]["slot_av"] = $slot_av;
                        $arraySlots[$slotRow["slot_id"]]["slot_av_max"] = $slot_av_max;
                        $arraySlots[$slotRow["slot_id"]]["booked"] = $booked;
                    }

                }

            }
        }

		return $arraySlots;
	}
	
	public function getSlotsByReservationsList($reservations) {
		$arraySlots = Array();
		$arrayReservations = explode(",",$reservations);
		$listReservations = "";
		for($i=0;$i<count($arrayReservations);$i++) {
			if($listReservations=="") {
				$listReservations.="'".$arrayReservations[$i]."'";
			} else {
				$listReservations.=",'".$arrayReservations[$i]."'";
			}
		}
		$slotsQry = $this->db->query("SELECT * FROM booking_reservation WHERE SHA1(CONCAT(reservation_id, slot_id)) IN (".$listReservations.")");
        $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            array_push($arraySlots,$row["slot_id"]);
        }
		return $arraySlots;
	}	
	
	public function getCustomerDataList($reservations) {
		
		$arrayReservations = explode(",",$reservations);
		$listReservations = "";
		for($i=0;$i<count($arrayReservations);$i++) {
			if($listReservations=="") {
				$listReservations.="'".$arrayReservations[$i]."'";
			} else {
				$listReservations.=",'".$arrayReservations[$i]."'";
			}
		}
        $slotsQry = $this->db->query("SELECT * FROM booking_reservation WHERE SHA1(CONCAT(reservation_id, slot_id)) IN (".$listReservations.") LIMIT 1");
        $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
		$slotRow = $rows[0];
		
		return $slotRow["reservation_id"];
	}	
	
	
	
}

?>
