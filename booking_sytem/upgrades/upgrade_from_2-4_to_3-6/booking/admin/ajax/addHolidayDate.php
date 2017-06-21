<?php
include '../common.php';
if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0) {
	if($_REQUEST["add_dates"]==1) {
		$date = str_replace(",","-",$_REQUEST["date_from"]);
		
		$newid=$holidayObj->addHoliday($date,"",$_GET["calendar_id"]);
		$newnum=$holidayObj->getHolidayRecordcount($_GET["calendar_id"]);
		if($newnum % 2) {
			$newclass="alternate_table_row_white";
		} else {
			$newclass="alternate_table_row_grey";
		}
	
		if($newid != '0') {
			
			?>
			<div id="row_<?php echo $newid; ?>">
				<div class="holidays_row_col1 <?php echo $newclass; ?>">
					<div id="table_cell"><?php echo $newnum; ?></div>
				</div>
				<div class="holidays_row_col2 <?php echo $newclass; ?>">
					<div id="table_cell"><input type="checkbox" name="holidays[]" value="<?php echo $newid; ?>" onclick="javascript:disableSelectAll('manage_holidays',this.checked);" /></div>
				</div>                    
				<div class="holidays_row_col3 <?php echo $newclass; ?>">
					<div id="table_cell">
                    	<?php
						if($settingObj->getDateFormat() == "UK") {
							$dateToSend = strftime('%d/%m/%Y',strtotime($date));
						} else if($settingObj->getDateFormat() == "EU") {
							$dateToSend = strftime('%Y/%m/%d',strtotime($date));
						} else {
							$dateToSend = strftime('%m/%d/%Y',strtotime($date));
						}
						?>
						<?php echo $dateToSend; ?>
                    </div>
				</div>
				<div class="holidays_row_col4 <?php echo $newclass; ?>">
					<div id="table_cell"><a href="javascript:delItem(<?php echo $newid; ?>,'holidays','holiday_id');"><?php echo $langObj->getLabel("HOLIDAYS_DELETE"); ?></a></div>
				</div>
				<div id="empty"></div>
			</div>
		<?php
		}
	} else {
        $date_from = str_replace(",","-",$_REQUEST["date_from"]);
		$date_to = str_replace(",","-",$_REQUEST["date_to"]);
		
		$num=$holidayObj->getHolidayRecordcount($_GET["calendar_id"]);
		$arrNewIds = Array();
		$arrNewIds=$holidayObj->addHoliday($date_from,$date_to,$_GET["calendar_id"]);
		for($i=0;$i<count($arrNewIds);$i++) {
			$holidayObj->setHoliday($arrNewIds[$i]);
			if($num % 2) {
				$newclass="alternate_table_row_grey";
			} else {
				$newclass="alternate_table_row_white";
			}
			$num++;
			?>
			<div id="row_<?php echo $arrNewIds[$i]; ?>">
				<div class="holidays_row_col1 <?php echo $newclass; ?>">
					<div id="table_cell"><?php echo $num; ?></div>
				</div>
				<div class="holidays_row_col2 <?php echo $newclass; ?>">
					<div id="table_cell"><input type="checkbox" name="holidays[]" value="<?php echo $arrNewIds[$i]; ?>" onclick="javascript:disableSelectAll('manage_holidays',this.checked);" /></div>
				</div>                    
				<div class="holidays_row_col3 <?php echo $newclass; ?>">
					<div id="table_cell">
                    	<?php
						if($settingObj->getDateFormat() == "UK") {
							$dateToSend = strftime('%d/%m/%Y',strtotime($holidayObj->getHolidayDate()));
						} else if($settingObj->getDateFormat() == "EU") {
							$dateToSend = strftime('%Y/%m/%d',strtotime($holidayObj->getHolidayDate()));
						} else {
							$dateToSend = strftime('%m/%d/%Y',strtotime($holidayObj->getHolidayDate()));
						}
						?>
						<?php echo $dateToSend; ?>
                    </div>
				</div>
				<div class="holidays_row_col4 <?php echo $newclass; ?>">
					<div id="table_cell"><a href="javascript:delItem(<?php echo $arrNewIds[$i]; ?>,'holidays','holiday_id');"><?php echo $langObj->getLabel("HOLIDAYS_DELETE"); ?></a></div>
				</div>
				<div id="empty"></div>
			</div>
			<?php
			
		}
	}
}

?>