<script>
	function filterPagSlots(pag) {
		if($("#search_date option:selected").val()==1) {
			
			if(Trim($('#first_date').val()) != '') {
				$('#result_search').html('<img src="images/loading.gif">');
				$.ajax({
				  url: 'ajax/filterSlots.php?search_date=1&date_from='+$('#first_date').val()+"&time_from="+$('#time_from').val()+"&time_to="+$('#time_to').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>&pag="+pag,
				  success: function(data) {
					 // $('#date_from').val('');
					  //$('#time_from').val('');
					  //$('#time_to').val('');
					  //$('#first_date').val('');
					 $('#table').hide().html(data).fadeIn(2000);
					 $('#result_search').html('');
					 goToByScroll("results");
				  }
				});
			} else {
			  alert("<?php echo addslashes($langObj->getLabel("SLOTS_SELECT_DATE_ALERT")); ?>");
			}
		} else if($("#search_date option:selected").val()==2 && Trim($('#first_date').val()) != '' && Trim($('#second_date').val()) != '') {
			$('#result_search').html('<img src="images/loading.gif">');
			$.ajax({
			  url: 'ajax/filterSlots.php?search_date=2&date_from='+$('#first_date').val()+"&weekday="+$('#slot_week_day').val()+"&date_to="+$('#second_date').val()+"&time_from="+$('#time_from').val()+"&time_to="+$('#time_to').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>&pag="+pag,
			  success: function(data) {
				  //$('#date_from').val('');
				  //$('#date_to').val('');
				  //$('#first_date').val('');
				  //$('#second_date').val('');
				  //$('#slot_week_day').val("0");
				  //$('#time_from').val('');
				  //$('#time_to').val('');
				 $('#table').hide().html(data).fadeIn(2000);
				 $('#result_search').html('');
				 goToByScroll("results");
			  }
			});
		} else {
			alert("<?php echo addslashes($langObj->getLabel("SLOTS_DATE_RANGE_ALERT")); ?>");
		}
	}
</script>
<?php
$arrayTotSlots = $listObj->getSlotsList($_SESSION["qrySlotsFilterString"],$_SESSION["qrySlotsOrderString"],$_GET["calendar_id"]);
$slotPerPag=100;
$totPages=ceil(count($arrayTotSlots)/$slotPerPag);
if(!isset($_GET["pag"])) {
	$_GET["pag"] = 1;
}

$pag = $_GET["pag"];
//pagination
if($totPages>1) {
	echo $langObj->getLabel("SLOTS_PAGES").":&nbsp;";
	if($_GET["pag"]>1) {
		?>
		<a href="javascript:filterPagSlots(1);"><?php echo $langObj->getLabel("SLOTS_PAGINATION_FIRST"); ?></a>
		
		<a href="javascript:filterPagSlots(<?php echo ($_GET["pag"]-1);?>);"><?php echo $langObj->getLabel("SLOTS_PAGINATION_PREV"); ?></a>
		<?php
	}
	
	for($j=1;$j<=$totPages;$j++) {
		if($j==$_GET["pag"]) {
			echo $j;
		} else {
		?>
		<a href="javascript:filterPagSlots(<?php echo $j; ?>);"><?php echo $j; ?></a>
		<?php
		}
	}
	if($_GET["pag"]<$totPages) {
		?>
		<a href="javascript:filterPagSlots(<?php echo ($_GET["pag"]+1);?>);"><?php echo $langObj->getLabel("SLOTS_PAGINATION_NEXT"); ?></a>
		<a href="javascript:filterPagSlots(<?php echo $totPages; ?>);"><?php echo $langObj->getLabel("SLOTS_PAGINATION_LAST"); ?></a>    
		<?php
	}
}
?>
<div>
<div class="slots_title_col1">
    <div id="table_cell">#</div>
</div>
<div class="slots_title_col2">
    <div id="table_cell"><input type="checkbox" name="selectAll" onclick="javascript:selectCheckbox('manage_slots','slots[]');" /></div>
</div>
<div class="slots_title_col3">
    <div id="table_cell"><?php echo $langObj->getLabel("SLOTS_DATE_LABEL")?>&nbsp;<a href="javascript:orderby('date','<?php echo $_SESSION["orderbySlotsDate"]; ?>');"><img src="images/orderby_<?php echo $_SESSION["orderbySlotsDate"];?>.gif" border=0 /></a></div>
</div>
<div class="slots_title_col4">
    <div id="table_cell"><?php echo $langObj->getLabel("SLOTS_TIME_FROM_LABEL")?>&nbsp;<a href="javascript:orderby('time','<?php echo $_SESSION["orderbySlotsTime"]; ?>');"><img src="images/orderby_<?php echo $_SESSION["orderbySlotsTime"];?>.gif" border=0 /></a></div>
</div>  
<div class="slots_title_col5">
    <div id="table_cell"><?php echo $langObj->getLabel("SLOTS_TIME_TO_LABEL")?></div>
</div> 
<div class="slots_title_col6">
    <div id="table_cell"><?php echo $langObj->getLabel("SLOTS_SPECIAL_TEXT_LABEL")?></div>
</div>
<div class="slots_title_col7">
    <div id="table_cell"><?php echo $langObj->getLabel("SLOTS_PRICE_LABEL")?></div>
</div>       
<div class="slots_title_col8">
    <div id="table_cell"><?php echo $langObj->getLabel("SLOTS_AV_LABEL");?></div>
</div> 
<div class="slots_title_col9">
    <div id="table_cell"><?php echo $langObj->getLabel("SLOTS_AV_MAX_LABEL");?></div>
</div>  
<div class="slots_title_col10">
    <div id="table_cell"><?php echo $langObj->getLabel("SLOTS_RESERVATION_LABEL")?></div>
</div>
<div class="slots_title_col11">
    <div id="table_cell"></div>
</div>
<div class="slots_title_col12">
    <div id="table_cell"></div>
</div>
<div id="empty"></div>
<?php                         
if($settingObj->getDateFormat() == "UK") {
	$date_format = "d/m/Y";
} else if($settingObj->getDateFormat() == 'EU') {
	$date_format = "Y/m/d";
} else {
	$date_format = "m/d/Y";
}
$arraySlots = $listObj->getSlotsList($_SESSION["qrySlotsFilterString"],$_SESSION["qrySlotsOrderString"],$_GET["calendar_id"],$slotPerPag,$_GET["pag"]);                    
$i=1;
foreach($arraySlots as $slotId => $slot) {							
	if($i % 2) {
		$class="alternate_table_row_white";
	} else {
		$class="alternate_table_row_grey";
	}
?>
<div id="row_<?php echo $slotId; ?>">
	<div class="slots_row_col1 <?php echo $class; ?>">
		<div id="table_cell"><?php echo $i; ?></div>
	</div>
	<div class="slots_row_col2 <?php echo $class; ?>">
		<div id="table_cell"><input type="checkbox" name="slots[]" value="<?php echo $slotId; ?>" onclick="javascript:disableSelectAll('manage_slots',this.checked);" /></div>
	</div>                    
	<div class="slots_row_col3 <?php echo $class; ?>">
		<div id="table_cell">
			<span id="date_display_<?php echo $slotId; ?>">
            	<?php
				if($settingObj->getDateFormat() == "UK") {
					$dateToSend = strftime('%d/%m/%Y',strtotime($slot["slot_date"]));
				} else if($settingObj->getDateFormat() == "EU") {
					$dateToSend = strftime('%Y/%m/%d',strtotime($slot["slot_date"]));
				} else {
					$dateToSend = strftime('%m/%d/%Y',strtotime($slot["slot_date"]));
				}
				?>
				<?php echo $dateToSend; ?>
            </span>
            <span id="date_input_<?php echo $slotId; ?>" style="display:none"><input type="text" name="slot_date" id="slot_date_<?php echo $slotId; ?>" class="date_input" style="width:110px" value="<?php echo date($date_format,strtotime($slot["slot_date"])); ?>" readonly="readonly"><input type="hidden" name="date_input_<?php echo $slotId; ?>" id="date_value_<?php echo $slotId; ?>" value="<?php echo $slot["slot_date"]; ?>"></span>
        </div>
	</div>
    <div class="slots_row_col4 <?php echo $class; ?>">
		<div id="table_cell">
			<span id="time_from_display_<?php echo $slotId; ?>">
            	<?php
				if($settingObj->getTimeFormat() == "12") {
					$slotTimeFrom = date('h:i a',strtotime(substr($slot["slot_time_from"],0,5)));
					
				} else {
					$slotTimeFrom = substr($slot["slot_time_from"],0,5);
					
				}
				echo $slotTimeFrom;
				?>
				
            </span>
            <span id="time_from_input_<?php echo $slotId; ?>" style="display:none">
		<select name="slot_time_from_hour[]" id="slot_time_from_hour_<?php echo $slotId; ?>" style="width:60px">
                        <option value=""><?php echo $langObj->getLabel("SLOTS_HOUR"); ?></option>
                        
                        <?php
						if($settingObj->getTimeFormat() == '24') {
							$start=0;
							$to = 24;
							$ampm=0;
						} else {
							$start=1;
							$to = 12;
							$ampm = 1;
						}
                        for($j=$start;$j<=$to;$j++) {
							$temp = $j;
							if(strlen($j) == 1) {
								$temp = '0'.$j; 
							}
                            ?>
                            <option value="<?php echo $j; ?>" <?php if($temp==substr($slotTimeFrom,0,2)) { echo "selected"; }?>><?php echo $j; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <select name="slot_time_from_minute[]" id="slot_time_from_minute_<?php echo $slotId; ?>" style="width:60px">
                        <option value=""><?php echo $langObj->getLabel("SLOTS_MINUTE"); ?></option>
                        <?php						
                        for($j=0;$j<=59;$j++) {
							$temp = $j;
							if(strlen($j) == 1) {
								$temp = '0'.$j; 
							}
                            ?>
                            <option value="<?php echo $j; ?>" <?php if($temp==substr($slotTimeFrom,3,2)) { echo "selected"; }?>><?php echo $temp; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php
                    if($ampm == 1) {
                        ?>
                        <select name="slot_time_from_ampm[]" id="slot_time_from_ampm_<?php echo $slotId; ?>" style="width:60px">
                            <option value="am" <?php if('am'==substr($slotTimeFrom,-2)) { echo "selected"; }?>>am</option>
                            <option value="pm" <?php if('pm'==substr($slotTimeFrom,-2)) { echo "selected"; }?>>pm</option>
                        </select>
                        <?php
                    }
                    ?>
                    
                </span>
        </div>
	</div>
    <div class="slots_row_col5 <?php echo $class; ?>">
		<div id="table_cell">
			<span id="time_to_display_<?php echo $slotId; ?>">
            	<?php
				if($settingObj->getTimeFormat() == "12") {
					$slotTimeTo = date('h:i a',strtotime(substr($slot["slot_time_to"],0,5)));
					
				} else {
					$slotTimeTo = substr($slot["slot_time_to"],0,5);
					
				}
				echo $slotTimeTo;
				?>
				
            </span>
            <span id="time_to_input_<?php echo $slotId; ?>" style="display:none">
		<select name="slot_time_to_hour[]" id="slot_time_to_hour_<?php echo $slotId; ?>" style="width:60px">
                        <option value=""><?php echo $langObj->getLabel("SLOTS_HOUR"); ?></option>
                        <?php
                        if($settingObj->getTimeFormat() == '24') {
							$start=0;
							$to = 24;
							$ampm=0;
						} else {
							$start=1;
							$to = 12;
							$ampm = 1;
						}
                        for($j=$start;$j<=$to;$j++) {
							$temp = $j;
							if(strlen($j) == 1) {
								$temp = '0'.$j; 
							}
                            ?>
                            <option value="<?php echo $j; ?>" <?php if($temp==substr($slotTimeTo,0,2)) { echo "selected"; }?>><?php echo $j; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <select name="slot_time_to_minute[]" id="slot_time_to_minute_<?php echo $slotId; ?>" style="width:60px">
                        <option value=""><?php echo $langObj->getLabel("SLOTS_MINUTE"); ?></option>
                        <?php						
                        for($j=0;$j<=59;$j++) {
							$temp = $j;
							if(strlen($j) == 1) {
								$temp = '0'.$j; 
							}
                            ?>
                            <option value="<?php echo $j; ?>" <?php if($temp==substr($slotTimeTo,3,2)) { echo "selected"; }?>><?php echo $j; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php
                    if($ampm == 1) {
                        ?>
                        <select name="slot_time_to_ampm[]" id="slot_time_to_ampm_<?php echo $slotId; ?>" style="width:60px">
                            <option value="am" <?php if('am'==substr($slotTimeTo,-2)) { echo "selected"; }?>>am</option>
                            <option value="pm" <?php if('pm'==substr($slotTimeTo,-2)) { echo "selected"; }?>>pm</option>
                        </select>
                        <?php
                    }
                    ?>
                	
                </span>
        </div>
	</div>
    <div class="slots_row_col6 <?php echo $class; ?>">
		<div id="table_cell">
        	
        	<span id="text_display_<?php echo $slotId; ?>"><?php echo substr($slot["slot_special_text"],0,20); ?></span>
            <span id="text_input_<?php echo $slotId; ?>" style="display:none"><input type="text" name="slot_special_text" id="slot_special_text_<?php echo $slotId; ?>" class="time_input" style="width:140px"  value="<?php echo $slot["slot_special_text"]; ?>"></span>
           
        </div>
	</div>
    <div class="slots_row_col7 <?php echo $class; ?>">
		<div id="table_cell">
        	<?php
			if($settingObj->getPaypalDisplayPrice() == 1) {
			?>
        	<span id="price_display_<?php echo $slotId; ?>">
            	<?php
				if(!function_exists('money_format')) {
					echo $utilsObj->money_format('%!.2n',$slot["slot_price"])."&nbsp;".$settingObj->getPaypalCurrency();
				} else {
					echo money_format('%!.2n',$slot["slot_price"])."&nbsp;".$settingObj->getPaypalCurrency(); 
				}
				?>
            </span>
            <span id="price_input_<?php echo $slotId; ?>" style="display:none"><input type="text" name="slot_price" id="slot_price_<?php echo $slotId; ?>" class="time_input" style="width:90px"  value="<?php echo $slot["slot_price"]; ?>"></span>
            <?php
			}
			?>
        </div>
	</div>
    <div class="slots_row_col8 <?php echo $class; ?>">
		<div id="table_cell">
        	<?php
			if($settingObj->getSlotsUnlimited() == 2) {
			?>
        	<span id="av_display_<?php echo $slotId; ?>"><?php echo $slot["slot_av"]; ?></span>
            <span id="av_input_<?php echo $slotId; ?>" style="display:none"><input type="text" name="slot_av" id="slot_av_<?php echo $slotId; ?>" class="time_input" style="width:90px"  value="<?php echo $slot["slot_av"]; ?>"></span>
            <?php
			}
			?>
        </div>
	</div>
    <div class="slots_row_col9 <?php echo $class; ?>">
		<div id="table_cell">
        	<?php
			if($settingObj->getSlotsUnlimited() == 2) {
			?>
        	<span id="av_max_display_<?php echo $slotId; ?>"><?php echo $slot["slot_av_max"]; ?></span>
            <span id="av_max_input_<?php echo $slotId; ?>" style="display:none !important"><input type="text" name="slot_av_max" id="slot_av_max_<?php echo $slotId; ?>" class="time_input" style="width:90px"  value="<?php echo $slot["slot_av_max"]; ?>"></span>
            <?php
			}
			?>
        </div>
	</div>
   
    <div class="slots_row_col10 <?php echo $class; ?>">
		<div id="table_cell">
        	<?php
			echo $slot["slot_reservation"];
			?>
			
        </div>
	</div>
    <div class="slots_row_col11 <?php echo $class; ?>">
		<div id="table_cell"><span id="modify_<?php echo $slotId; ?>"><a href="javascript:editItem(<?php echo $slotId; ?>,'<?php echo $slot["slot_reservation"]; ?>');"><?php echo $langObj->getLabel("SLOTS_MODIFY")?></a></span></div>
	</div>
	<div class="slots_row_col12 <?php echo $class; ?>">
		<div id="table_cell"><a href="javascript:delItem(<?php echo $slotId; ?>,'<?php echo $slot["slot_reservation"]; ?>');"><?php echo $langObj->getLabel("SLOTS_DELETE")?></a></div>
	</div>
	<div id="empty"></div>
</div>
<?php 
$i++;
} ?>
</div>
<?php
//pagination
if($totPages>1) {
	echo $langObj->getLabel("SLOTS_PAGES").":&nbsp;";
	if($_GET["pag"]>1) {
		?>
		<a href="javascript:filterPagSlots(1);"><?php echo $langObj->getLabel("SLOTS_PAGINATION_FIRST"); ?></a>
		
		<a href="javascript:filterPagSlots(<?php echo ($_GET["pag"]-1);?>);"><?php echo $langObj->getLabel("SLOTS_PAGINATION_PREV"); ?></a>
		<?php
	}
	
	for($j=1;$j<=$totPages;$j++) {
		if($j==$_GET["pag"]) {
			echo $j;
		} else {
		?>
		<a href="javascript:filterPagSlots(<?php echo $j; ?>);"><?php echo $j; ?></a>
		<?php
		}
	}
	if($_GET["pag"]<$totPages) {
		?>
		<a href="javascript:filterPagSlots(<?php echo ($_GET["pag"]+1);?>);"><?php echo $langObj->getLabel("SLOTS_PAGINATION_NEXT"); ?></a>
		<a href="javascript:filterPagSlots(<?php echo $totPages; ?>);"><?php echo $langObj->getLabel("SLOTS_PAGINATION_LAST"); ?></a>    
		<?php
	}
}
?>
