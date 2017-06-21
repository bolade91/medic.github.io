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
        $slotsQry = $this->db->prepare("SELECT DISTINCT slot_time_from FROM booking_slots WHERE slot_date >= DATE_FORMAT(NOW(),'%Y-%m-%d') AND slot_active = 1 AND calendar_id = ? ORDER BY slot_time_from");
        $slotsQry->execute(array($calendar_id));
        $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            array_push($arraySlots,$row["slot_time_from"]);
        }
		return $arraySlots;
	}	
	
	public function getSlotsList($filter,$order_by,$calendar_id,$num = 0,$pag = 0) {
		$arraySlots = Array();
		if($pag == 0) {
            $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_active = 1 AND calendar_id = ? ".$filter." ".$order_by);
            $slotsQry->execute(array($calendar_id));
		} else {
			if($pag == 1) {
				$start = 0;
			} else {
				$start=(($pag-1)*$num)+1;
			}
            $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE slot_active = 1 AND calendar_id = ? ".$filter." ".$order_by." LIMIT ".$start.",".$num);
            $slotsQry->execute(array($calendar_id));
		}
        $rows = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $arraySlots[$row["slot_id"]] = Array();
            $arraySlots[$row["slot_id"]]["slot_date"] = $row["slot_date"];
            $arraySlots[$row["slot_id"]]["slot_time_from"] = $row["slot_time_from"];
            $arraySlots[$row["slot_id"]]["slot_time_to"] = $row["slot_time_to"];
            $arraySlots[$row["slot_id"]]["slot_special_text"] = stripslashes($row["slot_special_text"]);
            $arraySlots[$row["slot_id"]]["slot_price"] = $row["slot_price"];
            $arraySlots[$row["slot_id"]]["slot_av"] = $row["slot_av"];
            $arraySlots[$row["slot_id"]]["slot_av_max"] = $row["slot_av_max"];
            $reservationQry = $this->db->prepare("SELECT SUM(reservation_seats) as res FROM booking_reservation WHERE slot_id = ? AND reservation_cancelled = 0 AND reservation_fake = 0 GROUP BY slot_id");
            $reservationQry->execute(array($row["slot_id"]));
            $reservation = 0;
            if($reservationQry->rowCount()>0) {
                $rowsRes = $reservationQry->fetchAll(PDO::FETCH_ASSOC);
                $reservation=$rowsRes[0]["res"];
            }
            $arraySlots[$row["slot_id"]]["slot_reservation"] = $reservation;
        }
		return $arraySlots;
	}	
	
	public function getReservationsList($filter,$order_by,$calendar_id) {
		$arrayReservations = Array();
        $reservationsQry = $this->db->prepare("SELECT * FROM booking_reservation r INNER JOIN booking_slots s ON s.slot_id=r.slot_id WHERE r.calendar_id = ? AND s.calendar_id = ? AND reservation_fake = 0 ".$filter." ".$order_by);
        $reservationsQry->execute(array($calendar_id,$calendar_id));

        $rows = $reservationsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $arrayReservations[$row["reservation_id"]] = Array();
            $arrayReservations[$row["reservation_id"]]["reservation_date"] = $row["slot_date"];
            $arrayReservations[$row["reservation_id"]]["reservation_time"] = $row["slot_time_from"];
            $arrayReservations[$row["reservation_id"]]["reservation_surname"] = stripslashes($row["reservation_surname"]);
            $arrayReservations[$row["reservation_id"]]["reservation_name"] = stripslashes($row["reservation_name"]);
            $arrayReservations[$row["reservation_id"]]["reservation_phone"] = stripslashes($row["reservation_phone"]);
            $arrayReservations[$row["reservation_id"]]["reservation_message"] = stripslashes($row["reservation_message"]);
            $arrayReservations[$row["reservation_id"]]["reservation_email"] = $row["reservation_email"];
            $arrayReservations[$row["reservation_id"]]["reservation_seats"] = $row["reservation_seats"];
            $arrayReservations[$row["reservation_id"]]["reservation_confirmed"] = $row["reservation_confirmed"];
            $arrayReservations[$row["reservation_id"]]["reservation_cancelled"] = $row["reservation_cancelled"];
            $arrayReservations[$row["reservation_id"]]["slot_active"] = $row["slot_active"];
        }
		return $arrayReservations;
	}	
	
	public function getCalendarsList($filter = '') {
		$arrayCalendars = Array();
        $calendarsQry = $this->db->query("SELECT * FROM booking_calendars WHERE 0=0 ".$filter." ORDER BY calendar_order");
        $rows = $calendarsQry->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row) {
            $arrayCalendars[$row["calendar_id"]] = Array();
            $arrayCalendars[$row["calendar_id"]]["calendar_title"] = stripslashes($row["calendar_title"]);
            $arrayCalendars[$row["calendar_id"]]["calendar_order"] = $row["calendar_order"];
            $arrayCalendars[$row["calendar_id"]]["calendar_active"] = $row["calendar_active"];
            $arrayCalendars[$row["calendar_id"]]["category_id"] = $row["category_id"];
        }

		return $arrayCalendars;
	}
	
	public function getCalendarsResList() {
		$arrayCalendars = Array();
        $calendarsQry = $this->db->query("SELECT c.*, COUNT(r.reservation_id) as tot_reservation FROM booking_calendars c LEFT JOIN booking_reservation r ON r.calendar_id = c.calendar_id AND r.reservation_fake = 0  GROUP BY c.calendar_id ORDER BY c.calendar_order");
        $rows = $calendarsQry->fetchAll(PDO::FETCH_ASSOC);
		foreach($rows as $row) {
            $arrayCalendars[$row["calendar_id"]] = Array();
            $arrayCalendars[$row["calendar_id"]]["calendar_title"] = $row["calendar_title"];
            $arrayCalendars[$row["calendar_id"]]["calendar_order"] = $row["calendar_order"];
            $arrayCalendars[$row["calendar_id"]]["calendar_active"] = $row["calendar_active"];
            $arrayCalendars[$row["calendar_id"]]["category_id"] = $row["category_id"];
            $arrayCalendars[$row["calendar_id"]]["tot_reservation"] = $row["tot_reservation"];
        }
		return $arrayCalendars;
	}
	
	public function getMailsList() {
		$arrayMails = Array();
        $mailsQry = $this->db->query("SELECT * FROM booking_emails");
        $rows = $mailsQry->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row) {
            $arrayMails[$row["email_id"]] = Array();
            $arrayMails[$row["email_id"]]["email_name"] = $row["email_name"];
        }

		return $arrayMails;
	}
	
	public function getPaypalLocaleList() {
		$arrayLocales = Array();
        $localesQry = $this->db->query("SELECT * FROM booking_paypal_locale ORDER BY locale_country");
        $rows = $localesQry->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row) {
            $arrayLocales[$row["locale_id"]] = Array();
            $arrayLocales[$row["locale_id"]]["locale_country"] = $row["locale_country"];
            $arrayLocales[$row["locale_id"]]["locale_code"] = $row["locale_code"];
        }
		return $arrayLocales;
	}
	
	public function getPaypalCurrencyList() {
		$arrayCurrencies = Array();
        $currenciesQry = $this->db->query("SELECT * FROM booking_paypal_currency ORDER BY currency_name");
        $rows = $currenciesQry->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row) {
            $arrayCurrencies[$row["currency_id"]] = Array();
            $arrayCurrencies[$row["currency_id"]]["currency_name"] = $row["currency_name"];
            $arrayCurrencies[$row["currency_id"]]["currency_code"] = $row["currency_code"];
        }

		return $arrayCurrencies;
	}
	
	public function getTextsList($page_id) {
		$arrayTexts = Array();
        $textsQry = $this->db->prepare("SELECT * FROM booking_texts WHERE page_id =?");
        $textsQry->execute(array($page_id));
        $rows = $textsQry->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row) {
            $arrayTexts[$row["text_id"]] = Array();
            $arrayTexts[$row["text_id"]]["text_label"] = $row["text_label"];
            $arrayTexts[$row["text_id"]]["text_value"] = stripslashes($row["text_value"]);
            $arrayTexts[$row["text_id"]]["page_id"] = $row["page_id"];
        }

		return $arrayTexts;
	}
	
	public function getCategoriesList() {
		$arrayCategories = Array();
        $categoriesQry = $this->db->query("SELECT * FROM booking_categories ORDER BY category_order");
        $rows = $categoriesQry->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as $row) {
            $arrayCategories[$row["category_id"]] = Array();
            $arrayCategories[$row["category_id"]]["category_name"] = stripslashes($row["category_name"]);
            $arrayCategories[$row["category_id"]]["category_order"] = $row["category_order"];
            $arrayCategories[$row["category_id"]]["category_active"] = $row["category_active"];
        }

		return $arrayCategories;
	}
}

?>
