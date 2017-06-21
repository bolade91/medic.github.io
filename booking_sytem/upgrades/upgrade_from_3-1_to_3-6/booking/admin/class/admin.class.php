<?php
class admin {
	private $user_id;
	private $qryUser;

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	public function setAdmin($id) {

        $userQry = $this->db->prepare("SELECT * FROM booking_admins WHERE admin_id = ? AND admin_active=1");
        $userQry->execute(array($id));
        $rows = $userQry->fetchAll(PDO::FETCH_ASSOC);

        if(isset($rows[0])) {
            $this->qryUser = $rows[0];
            $this->user_id = $rows[0]["admin_id"];
        }
		
	}
	
	public function doLogin($username, $password) {
		$returnvalue = 0;
        $query = $this->db->prepare("SELECT * FROM booking_admins WHERE admin_username = ? AND admin_password = ?");
        $query->execute(array($username,md5($password)));

        if($query->rowCount()>0) {
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
            $returnvalue = $rows[0]["admin_id"];
        }

		$this->setAdmin($returnvalue);
		
		return $returnvalue;
	}
	
	public function getAdminId() {
		return $this->user_id;
	}
	
	public function getAdminUsername() {
		return $this->qryUser["admin_username"];
	}
	
	public function updatePassword() {
        $query = $this->db->prepare("UPDATE booking_admins SET admin_password=? WHERE admin_id=?");
        $query->execute(array(md5($_POST["password"]),$_SESSION["admin_id"]));
	}
	
}

?>