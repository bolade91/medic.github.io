<?php

class category {
	private $category_id;
	private $categoryQry;

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	public function setCategory($id) {

        $categoryQry = $this->db->prepare("SELECT * FROM booking_categories WHERE category_id = ?");
        $categoryQry->execute(array($id));
        $rows = $categoryQry->fetchAll(PDO::FETCH_ASSOC);

        if(isset($rows[0])) {
            $this->categoryQry = $rows[0];
            $this->category_id = $rows[0]["category_id"];
        }
	}
	
	public function getCategoryId() {
		
		return $this->category_id;
	}
	
	public function getCategoryName() {
		
		return stripslashes($this->categoryQry["category_name"]);
	}
	
	public function getCategoryActive() {
		
		return $this->categoryQry["category_active"];
	}
	
	public function getCategoryOrder() {
		
		return $this->categoryQry["category_order"];
	}
	
	public function publishCategories($listIds) {
		$this->db->query("UPDATE booking_categories SET category_active = 1 WHERE category_id IN (".$listIds.")");
	}
	
	public function unpublishCategories($listIds) {
		$this->db->query("UPDATE booking_categories SET category_active = 0 WHERE category_id IN (".$listIds.")");
	}
	
	public function delCategories($listIds) {
		$this->db->query("DELETE FROM booking_categories WHERE category_id IN (".$listIds.")");

        $calendarsQry = $this->db->query("SELECT * FROM booking_calendars WHERE category_id IN (".$listIds.")");
        $rows = $calendarsQry->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row) {
            $query = $this->db->prepare("DELETE FROM booking_calendars WHERE calendar_id =".$row["calendar_id"]);
            $query->execute(array($row["calendar_id"]));
            //delete holidays
            $query = $this->db->prepare("DELETE FROM booking_holidays WHERE calendar_id =?");
            $query->execute(array($row["calendar_id"]));
            //check for reservations, if any disable slots, otherwise del slots
            $slotsQry = $this->db->prepare("SELECT * FROM booking_slots WHERE calendar_id =?");
            $slotsQry->execute($row["calendar_id"]);
            $rowsSlots = $slotsQry->fetchAll(PDO::FETCH_ASSOC);
            foreach($rowsSlots as $rowSlot) {
                $qry = $this->db->query("SELECT * FROM booking_reservation WHERE slot_id ='".$rowSlot["slot_id"]."'");
                $numRes = $qry->rowCount();
                if($numRes>0) {
                    $this->db->query("UPDATE booking_slots SET slot_active = 0 WHERE slot_id  =".$rowSlot["slot_id"]);
                } else {
                    $this->db->query("DELETE FROM booking_slots  WHERE slot_id =".$rowSlot["slot_id"]);
                }
            }
        }

		
		
	}
	
	public function addCategory($name) {
		
		$newOrder = 0;
		//check order of last calendar
        $calOrderQry = $this->db->query("SELECT category_order as max FROM booking_categories ORDER BY category_order DESC LIMIT 1");
		if($calOrderQry->rowCount()>0) {
            $rows = $calOrderQry->fetchAll(PDO::FETCH_ASSOC);
			$newOrder=$rows[0]['max']+1;
		}
        $query = $this->db->prepare("INSERT INTO booking_categories (category_name,category_order,category_active) VALUES(?,?,?)");
        $query->execute(array($name,$newOrder,0));

		$category_id=$this->db->lastInsertId();
		return $category_id;
	}
	
	
	public function getCategoryRecordcount() {
		$query = $this->db->query("SELECT * FROM booking_categories");
		return $query->rowCount();
	}
	
	public function setDefaultCategory($category_id) {
		$query = $this->db->prepare("UPDATE booking_categories SET category_order = 0, category_active = 1 WHERE category_id=?");
        $query->execute(array($category_id));

        $query = $this->db->prepare("UPDATE booking_categories SET category_order = category_order +1 WHERE category_id <> ?");
        $query->execute(array($category_id));
	}
	
	

}

?>