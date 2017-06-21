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
	
	

}

?>