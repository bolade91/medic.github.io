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
	
	public function getCategoryRecordcount() {
        $query = $this->db->query("SELECT * FROM booking_categories");
		return $query->rowCount();
	}
	
	public function getDefaultCategory() {
        $categoryQry = $this->db->query("SELECT * FROM booking_categories WHERE category_order = 0 AND category_active = 1");

		if($categoryQry->rowCount() > 0) {
            $rows = $categoryQry->fetchAll(PDO::FETCH_ASSOC);
			$categoryRow = $rows[0];
			$this->setCategory($categoryRow["category_id"]);
			return true;
		} else {
			return false;
		}
	}
	
	

}

?>