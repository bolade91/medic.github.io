<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	if($slotsObj->checkSlotsReservation() > 0) {
	?>
		<script>
            if(confirm("<?php echo addslashes($langObj->getLabel("MODIFY_SLOTS_ALERT")); ?>")) {
                window.parent.document.forms["delete_slots"].action="";
                window.parent.document.forms["delete_slots"].target="_self";
                window.parent.document.forms["delete_slots"].submit();
            } else {
				window.parent.document.getElementById('del_button').disabled=false;
			}
        </script>
    <?php
	} else {
	?>
		<script>            
			window.parent.document.getElementById('result_delete').innerHTML = "<img src='images/loading.gif'>";
			setTimeout("submitForm()",3000);
			function submitForm() {
				window.parent.document.forms["delete_slots"].action="";
				window.parent.document.forms["delete_slots"].target="_self";
				window.parent.document.forms["delete_slots"].submit();            
			}
        </script>
    <?php
	}
	
}
?>
