<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	//order by management
	if(isset($_REQUEST["order_by"]) && $_REQUEST["order_by"] != '' && isset($_REQUEST["type"]) && $_REQUEST["type"] != '') {
		
		switch($_REQUEST["order_by"]) {
			case "date":
				if($_REQUEST["type"] == 'asc') {
					$_SESSION["qryHolidaysOrderString"] = "ORDER BY holiday_date asc";
					$_SESSION["orderbyHolidayDate"] = "desc";
				} else {
					$_SESSION["qryHolidaysOrderString"] = "ORDER BY holiday_date desc";
					$_SESSION["orderbyHolidayDate"] = "asc";
				}
				break;
			
		}
	}
}

?>
<div class="holidays_title_col1">
    <div id="table_cell">#</div>
</div>
<div class="holidays_title_col2">
    <div id="table_cell"><input type="checkbox" name="selectAll" onclick="javascript:selectCheckbox('manage_holidays','holidays[]');" /></div>
</div>
<div class="holidays_title_col3">
    <div id="table_cell"><?php echo $langObj->getLabel("HOLIDAY_DATE_LABEL"); ?>&nbsp;<a href="javascript:orderby('<?php echo $_SESSION["orderbyHolidayDate"]; ?>');"><img src="images/orderby_<?php echo $_SESSION["orderbyHolidayDate"];?>.gif" border=0 /></a></div>
</div>        
<div class="holidays_title_col4">
    <div id="table_cell"></div>
</div>
<div id="empty"></div>
<?php                         
$arrayHolidays = $listObj->getHolidaysList($_SESSION["qryHolidaysOrderString"],$_GET["calendar_id"]);                        
$i=1;
foreach($arrayHolidays as $holidayId => $holiday) {							
	if($i % 2) {
		$class="alternate_table_row_white";
	} else {
		$class="alternate_table_row_grey";
	}
?>
<div id="row_<?php echo $holidayId; ?>">
	<div class="holidays_row_col1 <?php echo $class; ?>">
		<div id="table_cell"><?php echo $i; ?></div>
	</div>
	<div class="holidays_row_col2 <?php echo $class; ?>">
		<div id="table_cell"><input type="checkbox" name="holidays[]" value="<?php echo $holidayId; ?>" onclick="javascript:disableSelectAll('manage_holidays',this.checked);" /></div>
	</div>                    
	<div class="holidays_row_col3 <?php echo $class; ?>">
		<div id="table_cell">
        	<?php
			if($settingObj->getDateFormat() == "UK") {
				$dateToSend = strftime('%d/%m/%Y',strtotime($holiday["holiday_date"]));
			} else if($settingObj->getDateFormat() == "EU") {
				$dateToSend = strftime('%Y/%m/%d',strtotime($holiday["holiday_date"]));
			} else {
				$dateToSend = strftime('%m/%d/%Y',strtotime($holiday["holiday_date"]));
			}
			?>
			<?php echo $dateToSend; ?>
        </div>
	</div>
	<div class="holidays_row_col4 <?php echo $class; ?>">
		<div id="table_cell"><a href="javascript:delItem(<?php echo $holidayId; ?>,'holidays','holiday_id');"><?php echo $langObj->getLabel("HOLIDAYS_DELETE"); ?></a></div>
	</div>
	<div id="empty"></div>
</div>
<?php 
$i++;
} ?>