<?php

class email {
	private $mail_id;
	private $mailQry;

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	public function setMail($id) {
        $mailQry = $this->db->prepare("SELECT * FROM booking_emails WHERE email_id = ?");
        $mailQry->execute(array($id));
        $rows = $mailQry->fetchAll(PDO::FETCH_ASSOC);

        if(isset($rows[0])) {
            $this->mailQry = $rows[0];
            $this->mail_id = $rows[0]["email_id"];
        }
	}
	
	public function getMailId() {
		return $this->mail_id;
	}
	
	public function getMailName() {
		return stripslashes($this->mailQry["email_name"]);
	}
	
	public function getMailSubject() {
		return stripslashes($this->mailQry["email_subject"]);
	}
	
	public function getMailText() {
		return stripslashes($this->mailQry["email_text"]);
	}
	
	public function getMailCancelText() {
		return stripslashes($this->mailQry["email_cancel_text"]);
	}
	
	public function getMailSignature() {
		return stripslashes($this->mailQry["email_signature"]);
	}
	
	public function updateMail() {
		if(isset($_POST["mail_cancel_text"])) {
			$mail_cancel_text = $_POST["mail_cancel_text"];
		} else {
			$mail_cancel_text = "";
		}
        $query = $this->db->prepare("UPDATE booking_emails SET email_name=?,email_subject=?, email_text=?, email_cancel_text=?,email_signature=? WHERE email_id=?");
        $query->execute(array($_POST["mail_name"],$_POST["mail_subject"],$_POST["mail_text"],$mail_cancel_text,$_POST["mail_signature"],$this->getMailId()));

		
	}

}

?>