<?php 
include 'common.php';

if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}
//manage closing days operations
if(isset($_POST["operation"]) && $_POST["operation"] != '' && isset($_POST["holidays"])) {
	$arrHolidays=$_POST["holidays"];
	$qryString = "0";
	for($i=0;$i<count($arrHolidays); $i++) {
		$qryString .= ",".$arrHolidays[$i];
	}
		
	switch($_POST["operation"]) {
		case "delHolidays":
			$holidayObj->delHolidays($qryString);
			break;
	}                
	header('Location: calendar_manage.php?calendar_id='.$_GET["calendar_id"]."&ref=holidays");
}
//manage time slots operations
if(isset($_POST["operation"]) && $_POST["operation"] != '' && isset($_POST["slots"])) {
	
	$arrSlots=$_POST["slots"];
	$qryString = "0";
	for($i=0;$i<count($arrSlots); $i++) {
		$qryString .= ",".$arrSlots[$i];
	}
		
	switch($_POST["operation"]) {
		case "delSlots":
			$slotsObj->delSlots($qryString);
			
			break;
	}                
	header('Location: calendar_manage.php?calendar_id='.$_GET["calendar_id"]."&ref=slots");
}
if(isset($_POST["slot_hour_delete"])) {
	/***********first check if there are reservation for the selected time slots and alert*************/
	$_POST["calendar_id"] = $_GET["calendar_id"];
	if($slotsObj->checkSlotsReservation() == 0) {
		$numslots = $slotsObj->deleteSlots();
	} else {
		$numslots = $slotsObj->disableSlots();
	}
	?>
	<script>
        alert('<?php echo $numslots; ?> <?php echo addslashes($langObj->getLabel("DELETED_SLOTS_ALERT")); ?>');
		document.location.href="calendar_manage.php?calendar_id=<?php echo $_GET["calendar_id"]; ?>&ref=slots";
    </script>
    <?php
	
}
if(isset($_POST["slot_hour_edit"])) {
	/***********first check if there are reservation for the selected time slots and alert*************/
	$_POST["calendar_id"] = $_GET["calendar_id"];
	$numslots = $slotsObj->modifySlots();
	
	?>
	<script>
        alert('<?php echo $numslots; ?> <?php echo addslashes($langObj->getLabel("MODIFIED_SLOTS_ALERT")); ?>');
		document.location.href="calendar_manage.php?calendar_id=<?php echo $_GET["calendar_id"]; ?>&ref=slots";
    </script>
    <?php
	
}
if(isset($_POST["slot_date_from"])) {	
	
	$numslots=$slotsObj->addSlot();
	?>
	<script>
		<?php
		if($numslots>0) {
			?>
			alert('<?php echo $numslots; ?> <?php echo addslashes($langObj->getLabel("ADDED_SLOTS_ALERT")); ?>');
			<?php
		} else if($numslots == -1) {
			?>
			alert('<?php echo addslashes($langObj->getLabel("SELECTED_DAYS_HOLIDAY_ALERT")); ?>');
			<?php
		} else {
			?>
			alert('<?php echo addslashes($langObj->getLabel("DUPLICATE_SLOTS_ALERT")); ?>');
			<?php
		}
		?>
      
		document.location.href="calendar_manage.php?calendar_id=<?php echo $_GET["calendar_id"]; ?>&ref=slots";
    </script>
    <?php

	
}





include 'include/header.php';

$calendarObj->setCalendar($_GET["calendar_id"]);


?>

<!-- 
=====================================================================
=====================================================================
-->

<script>
	$(function() {
		<?php
		if(isset($_GET["ref"])) {
			?>
			showPage('<?php echo $_GET["ref"]; ?>');
			<?php
		}
		?>
	});
	function showPage(pagename) {
		$('#holidays_menu').css({"background-color":"#333"});
		$('#slots_menu').css({"background-color":"#333"});
		$('#reservation_menu').css({"background-color":"#333"});
		$.ajax({
		  url: 'ajax/showPage.php?pagename='+pagename+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
		  success: function(data) {
			  
			  $('#page_container').hide().html(data).slideDown(1000);
			  $('#'+pagename+'_menu').css({"background-color":"#666"});
		  }
		});
	}
	
</script>

<!-- 
=====================================================================
	layout
=====================================================================
-->

<div id="top_bg_container_all">
    <div id="container_all">
        <div id="container_content">
			<?php
            include 'include/menu.php';
            ?>
            <!-- breadcrumb -->
            <div id="action_bar">
            	<div class="breadcrumb"><?php echo $langObj->getLabel("CALENDAR_YOU_ARE_IN"); ?>: <?php echo $langObj->getLabel("CALENDARS"); ?> > <?php echo $calendarObj->getCalendarTitle(); ?> > <strong><?php echo $langObj->getLabel("CALENDARS_MANAGE"); ?></strong></div>
            </div>
            <?php
			$background = "";
			$status = "";
			if($calendarObj->getCalendarActive() == 1) {
				$background = "#00B478";
				$status = $langObj->getLabel("STATUS_PUBLISHED");
			} else {
				$background = "#E05B5B";
				$status = $langObj->getLabel("STATUS_UNPUBLISHED");
			}
			?>
            <!-- calendar status -->
            <div class="calendar_status" style="background:<?php echo $background; ?>"><?php echo $langObj->getLabel("ACTUAL_CALENDAR_STATUS"); ?>: <span style="text-transform:uppercase; font-weight: bold;"><?php echo $status; ?></span></div>
            
            <div id="cleardiv"></div>
            <div id="rowspace"></div>
            
            <!-- menu manage calendar -->
            <div id="menu_container_small">
                <div id="menu">
                    <ul>
                        <li><a href="javascript:showPage('slots');" id="slots_menu"><?php echo $langObj->getLabel("MANAGE_TIME_SLOTS"); ?></a></li>
                        <li><a href="javascript:showPage('holidays');" id="holidays_menu"><?php echo $langObj->getLabel("CLOSING_DAYS"); ?></a></li>
                    </ul>
                </div>
            </div>
            <div id="cleardiv"></div>
            <div id="rowspace"></div>
            
            
            <div id="page_container">
            	<!-- contents by js -->
            </div>
            <div id="cleardiv"></div>
            <div id="rowspace"></div>
        </div>
    </div>
</div>
<?php
include 'include/footer.php';
?>