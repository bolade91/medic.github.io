<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	/********check if there are reservation and if there are slots with same time/date***********/
	$result=$slotsObj->checkEditSlotsReservation();
	if($result > 0) {
	?>
		<script>
            if(confirm("<?php echo addslashes($langObj->getLabel("MODIFY_SLOTS_ALERT")); ?>")) {
                window.parent.document.forms["modify_slots"].action="";
                window.parent.document.forms["modify_slots"].target="_self";
                window.parent.document.forms["modify_slots"].submit();
            } else {
				window.parent.document.getElementById('edit_button').disabled=false;
			}
        </script>
    <?php
	} else if($result == 0) {
	?>
		<script>            
			window.parent.document.getElementById('result_modify').innerHTML = "<img src='images/loading.gif'>";
			setTimeout("submitForm()",3000);
			function submitForm() {
				window.parent.document.forms["modify_slots"].action="";
				window.parent.document.forms["modify_slots"].target="_self";
				window.parent.document.forms["modify_slots"].submit();            
			}
        </script>
    <?php
	} else if($result == -1) {
	?>
    <script>            
		alert("<?php echo addslashes($langObj->getLabel("DUPLICATE_SLOTS_ALERT")); ?>");
		window.parent.document.getElementById('edit_button').disabled=false;
	</script>
	<?php
	}
	
}
?>
