<?php

class lang {

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	private function doLanguageQuery($label) {
        $languageQry = $this->db->prepare("SELECT * FROM booking_texts WHERE text_label=?");
        $languageQry->execute(array($label));
        $rows = $languageQry->fetchAll(PDO::FETCH_ASSOC);
		return stripslashes($rows[0]["text_value"]);
	}
	
	public function getLabel($label) {
		return stripslashes($this->doLanguageQuery($label));
	}
	
	

}

?>
