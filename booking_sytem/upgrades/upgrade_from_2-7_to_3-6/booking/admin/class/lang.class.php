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
		return $this->doLanguageQuery($label);
	}
	
	public function updateTexts() {
		$arrayLabels=$_POST["text_label"];
		$arrayTexts=$_POST["text_value"];
		for($i=0;$i<count($arrayLabels);$i++) {
            $query = $this->db->prepare("UPDATE booking_texts SET text_value=? WHERE text_label=?");
            $query->execute(array($arrayTexts[$i],$arrayLabels[$i]));
		}
	
	}
	
	public function importLang() {
		$result = 0;
		$upload_dir = "../lang";
		if(isset($_FILES["admin_file"]["tmp_name"]) && $_FILES["admin_file"]["tmp_name"] != '') {
			if(move_uploaded_file($_FILES["admin_file"]["tmp_name"], $upload_dir . "/".str_replace(" ","",$_FILES["admin_file"]["name"]))) {
				//include the file
				$arrlang = Array();
				include $upload_dir . "/".str_replace(" ","",$_FILES["admin_file"]["name"]);
				$arrlang = $lang;
				foreach($arrlang as $key => $val) {
                    $query = $this->db->prepare("UPDATE booking_texts SET text_value = ? WHERE text_label = ?");
                    $query->execute($val,$key);
				}
				$result = 1;
				//delete file
				unlink($upload_dir . "/".str_replace(" ","",$_FILES["admin_file"]["name"]));
			}
			
		}
		if(isset($_FILES["public_file"]["tmp_name"]) && $_FILES["public_file"]["tmp_name"] != '') {
			if(move_uploaded_file($_FILES["public_file"]["tmp_name"], $upload_dir. "/".str_replace(" ","",$_FILES["public_file"]["name"]))) {
				//include the file
				$arrlang = Array();
				include $upload_dir . "/".str_replace(" ","",$_FILES["public_file"]["name"]);
				$arrlang = $lang;
				foreach($arrlang as $key => $val) {
                    $query = $this->db->prepare("UPDATE booking_texts SET text_value = ? WHERE text_label = ?");
                    $query->execute(array($val,$key));
				}
				$result = 1;
				//delete file
				unlink($upload_dir . "/".str_replace(" ","",$_FILES["public_file"]["name"]));
			}
			
		}
		return $result;
	}
	

}

?>
