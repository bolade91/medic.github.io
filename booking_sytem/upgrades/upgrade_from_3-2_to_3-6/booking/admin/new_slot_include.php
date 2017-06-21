
<script>
	
	var customopen = 0;
	$(function() {
		
		<?php
		if($settingObj->getDateFormat() == "UK") {
			?>
			$.datepicker.setDefaults( $.datepicker.regional[ "en-GB" ] );
			<?php
		} else if($settingObj->getDateFormat() == "EU") {
			?>
			$.datepicker.setDefaults( $.datepicker.regional[ "eu-EU" ] );
			<?php
		} else {
			?>
			$.datepicker.setDefaults( $.datepicker.regional[ "us-US" ] );
			<?php
		}
		?>

        $('input[name=slot_show_different_price]').each(function() {
            var val = $(this).val();
            $(this).bind('click',function() {
                showDiscountedPrice(val);
            });
        });

        $('input[name=slot_perc_or_discount]').each(function() {
            var val = $(this).val();
            $(this).bind('click',function() {
                showPercOrDiscount(val);
            });
        });
		$( "#slot_date_from").datepicker({
			altField: "#first_date",
			altFormat: "yy,mm,dd",
			minDate: new Date(),
			 onClose: function(selectedDate) { 
			 	
			 	  
			 	  $( "#slot_date_to").datepicker( "option", "minDate", selectedDate );
				 
				 		 
			}
			
			

		});
		$( "#slot_date_to").datepicker({
			altField: "#second_date",
			altFormat: "yy,mm,dd",
			onClose: function(selectedDate) {
				$( "#slot_date_from" ).datepicker( "option", "maxDate", selectedDate );
				$('#delete_button').fadeIn();
				$('#weekday_div').fadeIn();
				
			}
		});
		
		
		
	});
	function showCustom(choice) {
		
		if(choice == '0') {
			customopen = 1;
			$('#custom_fields').fadeIn("slow");
			
			$('#range_time').fadeOut("slow");
			$('#custom_minutes').fadeOut("slow");
			
		} else if(choice == '1') {
			
			customopen=0;
			$('#custom_fields').fadeOut("slow");
			$('#range_time').fadeIn("slow");
			$('#custom_minutes').fadeIn("slow");
			
			
		} else {
			customopen=0;
			$('#custom_fields').fadeOut("slow");
			$('#range_time').fadeOut("slow");
			$('#custom_minutes').fadeOut("slow");
			
		}
		
	}
	
	function addTime(num) {
		$('#add_time').attr("onClick","javascript:addTime("+(num+1)+");");
		htmlToAdd = '<div id="time_'+num+'" class="font_12"><br><br><?php echo addslashes($langObj->getLabel("SLOTS_FROM")); ?>&nbsp;';
		htmlToAdd+='<select name="slot_interval_custom_from_hour[]">';
		htmlToAdd+='<option value="">hour</option>';
                    <?php
                    if($settingObj->getTimeFormat() == '24') {
						$start=0;
                        $to = 23;
                        $ampm=0;
                    } else {
						$start=1;
                        $to = 12;
                        $ampm = 1;
                    }
                    for($i=$start;$i<=$to;$i++) {
						
                        ?>
                        htmlToAdd+='<option value="<?php echo $i; ?>"><?php echo $i; ?></option>';
                        <?php
                    }
                    ?>
                htmlToAdd+='</select>';
                htmlToAdd+='<select name="slot_interval_custom_from_minute[]">';
                htmlToAdd+='<option value="">minute</option>';
                    <?php						
                    for($i=0;$i<=59;$i++) {
						$num = $i;
						if(strlen($num) == 1) {
							$num = '0'.$num;
						}
                        ?>
                        htmlToAdd+='<option value="<?php echo $i; ?>"><?php echo $num; ?></option>';
                        <?php
                    }
                    ?>
                htmlToAdd+='</select>';
                <?php
                if($ampm == 1) {
                    ?>
                    htmlToAdd+='<select name="slot_interval_custom_from_ampm[]">';
                    htmlToAdd+='<option value="am">am</option>';
                    htmlToAdd+='<option value="pm">pm</option>';
                    htmlToAdd+='</select>';
                    <?php
                }
                ?>
                htmlToAdd+='&nbsp;';
               htmlToAdd+='&nbsp;';
				htmlToAdd+='<?php echo addslashes($langObj->getLabel("SLOTS_TO")); ?>&nbsp;';
                htmlToAdd+='<select name="slot_interval_custom_to_hour[]">';
                 htmlToAdd+='<option value="">hour</option>';
                    <?php
                    if($settingObj->getTimeFormat() == '24') {
						$start=0;
                        $to = 23;
                        $ampm=0;
                    } else {
						$start=1;
                        $to = 12;
                        $ampm = 1;
                    }
                    for($i=$start;$i<=$to;$i++) {
                        ?>
                        htmlToAdd+='<option value="<?php echo $i; ?>"><?php echo $i; ?></option>';
                        <?php
                    }
                    ?>
                htmlToAdd+='</select>';
                htmlToAdd+='<select name="slot_interval_custom_to_minute[]">';
                htmlToAdd+='<option value="">minute</option>';
                    <?php						
                    for($i=0;$i<=59;$i++) {
						$num = $i;
						if(strlen($num) == 1) {
							$num = '0'.$num;
						}
                        ?>
                        htmlToAdd+='<option value="<?php echo $i; ?>"><?php echo $num; ?></option>';
                        <?php
                    }
                    ?>
                htmlToAdd+='</select>';
                <?php
                if($ampm == 1) {
                    ?>
                    htmlToAdd+='<select name="slot_interval_custom_to_ampm[]">';
                    htmlToAdd+='<option value="am">am</option>';
                    htmlToAdd+='<option value="pm">pm</option>';
                    htmlToAdd+='</select>';
                    <?php
                }
                ?>
				htmlToAdd+='&nbsp;<input type="button" id="minus_'+num+'" value="-" onclick="javascript:delTime(\''+num+'\');"></div>';
		$('#custom_fields_add').append(htmlToAdd);
	}
	function delTime(num) {
		$('#time_'+num).remove();
		var length = document.forms["addslot"]["slot_interval_custom_from_hour[]"].length;
		
	}
	
	function addTimeRange(num) {
		$('#add_time_range').attr("onClick","javascript:addTimeRange("+(num+1)+");");
		htmlToAdd='<div id="time_range_'+num+'" class="font_12"><br><br><div class="float_left margin_t_10"><?php echo addslashes($langObj->getLabel("SLOTS_FROM")); ?></div>';
		htmlToAdd+='<div class="float_left margin_l_10">';
		htmlToAdd+='<select name="slot_time_from_hour[]">';
        htmlToAdd+='<option value="">hour</option>';
                        <?php
						if($settingObj->getTimeFormat() == '24') {
							$start=0;
							$to = 23;
							$ampm=0;
						} else {
							$start=1;
							$to = 12;
							$ampm = 1;
						}
						for($i=$start;$i<=$to;$i++) {
							?>
                            htmlToAdd+='<option value="<?php echo $i; ?>"><?php echo $i; ?></option>';
                            <?php
						}
						?>
                    htmlToAdd+='</select>';
                    htmlToAdd+='<select name="slot_time_from_minute[]">';
                    htmlToAdd+='<option value="">minute</option>';
                        <?php						
						for($i=0;$i<=59;$i++) {
							$num = $i;
							if(strlen($num) == 1) {
								$num = '0'.$num;
							}
							?>
                            htmlToAdd+='<option value="<?php echo $i; ?>"><?php echo $num; ?></option>';
                            <?php
						}
						?>
                    htmlToAdd+='</select>';
                    <?php
					if($ampm == 1) {
						?>
                        htmlToAdd+='<select name="slot_time_from_ampm[]">';
                        htmlToAdd+='<option value="am">am</option>';
                        htmlToAdd+='<option value="pm">pm</option>';
                        htmlToAdd+='</select>';
                        <?php
					}
					?>
                	
               	htmlToAdd+='</div>';
                
                htmlToAdd+='<div class="float_left margin_t_10 margin_l_10"><?php echo addslashes($langObj->getLabel("SLOTS_TO")); ?></div>';
                htmlToAdd+='<div class="float_left margin_l_10">';
                htmlToAdd+='<select name="slot_time_to_hour[]">';
                htmlToAdd+='<option value="0">hour</option>';
                        <?php
						if($settingObj->getTimeFormat() == '24') {
							$start=0;
							$to = 23;
							$ampm=0;
						} else {
							$start=1;
							$to = 12;
							$ampm = 1;
						}
						for($i=$start;$i<=$to;$i++) {
							?>
                            htmlToAdd+='<option value="<?php echo $i; ?>"><?php echo $i; ?></option>';
                            <?php
						}
						?>
                    htmlToAdd+='</select>';
                    htmlToAdd+='<select name="slot_time_to_minute[]">';
                    htmlToAdd+='<option value="">minute</option>';
                        <?php						
						for($i=0;$i<=59;$i++) {
							$num = $i;
							if(strlen($num) == 1) {
								$num = '0'.$num;
							}
							?>
                            htmlToAdd+='<option value="<?php echo $i; ?>"><?php echo $num; ?></option>';
                            <?php
						}
						?>
                    htmlToAdd+='</select>';
                    <?php
					if($ampm == 1) {
						?>
                        htmlToAdd+='<select name="slot_time_to_ampm[]">';
                            htmlToAdd+='<option value="am">am</option>';
                            htmlToAdd+='<option value="pm">pm</option>';
                        htmlToAdd+='</select>';
                        <?php
					}
					?>
                	
                htmlToAdd+='</div>';
                htmlToAdd+='&nbsp;<input type="button" id="minus_range_'+num+'" value="-" onclick="javascript:delTimeRange(\''+num+'\');"></div><div class="cleardiv"></div>';
		$('#time_ranges_add').append(htmlToAdd);
	}
	function delTimeRange(num) {
		$('#time_range_'+num).remove();
	}
	
	
	
	function clearDateTo() {
		$('#slot_date_to').val('');
		$('#second_date').val('');
		$('#weekday_div').fadeOut();
		$('#delete_button').fadeOut();
	}
	function checkSlotIntervalCustomTimes() {
		var error = 0;
		
		var len = document.getElementsByName('slot_interval_custom_from_hour[]').length;
		for(i=0;i<len;i++) {
			tempMinuteFrom = document.getElementsByName("slot_interval_custom_from_minute[]").item(i).value;
			if(document.getElementsByName("slot_interval_custom_from_minute[]").item(i).value.length == 1) {
				tempMinuteFrom = '0'+document.getElementsByName("slot_interval_custom_from_minute[]").item(i).value;
			}
			tempMinuteTo = document.getElementsByName("slot_interval_custom_to_minute[]").item(i).value;
			if(document.getElementsByName("slot_interval_custom_to_minute[]").item(i).value.length == 1) {
				tempMinuteTo = '0'+document.getElementsByName("slot_interval_custom_to_minute[]").item(i).value;
				
			}
			
			var from_value =document.getElementsByName("slot_interval_custom_from_hour[]").item(i).value+""+tempMinuteFrom;
			var to_value =document.getElementsByName("slot_interval_custom_to_hour[]").item(i).value+""+tempMinuteTo;
			if(document.getElementsByName("slot_interval_custom_from_ampm[]").item(i) && document.getElementsByName("slot_interval_custom_from_ampm[]").item(i).value=='am') {
				switch(document.getElementsByName("slot_interval_custom_from_hour[]").item(i).value) {
					case '12':
						from_value = '00'+tempMinuteFrom;
						break;
				}
			} else if(document.getElementsByName("slot_interval_custom_from_ampm[]").item(i) && document.getElementsByName("slot_interval_custom_from_ampm[]").item(i).value=='pm') {
				switch(document.getElementsByName("slot_interval_custom_from_hour[]").item(i).value) {
					case '1':
						from_value = '13'+tempMinuteFrom;
						break;
					case '2':
						from_value = '14'+tempMinuteFrom;
						break;
					case '3':
						from_value = '15'+tempMinuteFrom;
						break;
					case '4':
						from_value = '16'+tempMinuteFrom;
						break;
					case '5':
						from_value = '17'+tempMinuteFrom;
						break;
					case '6':
						from_value = '18'+tempMinuteFrom;
						break;
					case '7':
						from_value = '19'+tempMinuteFrom;
						break;
					case '8':
						from_value = '20'+tempMinuteFrom;
						break;
					case '9':
						from_value = '21'+tempMinuteFrom;
						break;
					case '10':
						from_value = '22'+tempMinuteFrom;
						break;
					case '11':
						from_value = '23'+tempMinuteFrom;
						break;
				}
			}
			if(document.getElementsByName("slot_interval_custom_to_ampm[]").item(i) && document.getElementsByName("slot_interval_custom_to_ampm[]").item(i).value=='am') {
				switch(document.getElementsByName("slot_interval_custom_to_hour[]").item(i).value) {
					case '12':
						to_value = '00'+tempMinuteTo;
						break;
				}
			} else if(document.getElementsByName("slot_interval_custom_to_ampm[]").item(i) && document.getElementsByName("slot_interval_custom_to_ampm[]").item(i).value=='pm') {
				switch(document.getElementsByName("slot_interval_custom_to_hour[]").item(i).value) {
					case '1':
						to_value = '13'+tempMinuteTo;
						break;
					case '2':
						to_value = '14'+tempMinuteTo;
						break;
					case '3':
						to_value = '15'+tempMinuteTo;
						break;
					case '4':
						to_value = '16'+tempMinuteTo;
						break;
					case '5':
						to_value = '17'+tempMinuteTo;
						break;
					case '6':
						to_value = '18'+tempMinuteTo;
						break;
					case '7':
						to_value = '19'+tempMinuteTo;
						break;
					case '8':
						to_value = '20'+tempMinuteTo;
						break;
					case '9':
						to_value = '21'+tempMinuteTo;
						break;
					case '10':
						to_value = '22'+tempMinuteTo;
						break;
					case '11':
						to_value = '23'+tempMinuteTo;
						break;
				}
			}
			
			/*if(from_value.substring(0,1) == "0") {
				from_value = parseInt(from_value.substring(1,4));
			}
			if(to_value.substring(0,1) == "0") {
				to_value = parseInt(to_value.substring(1,4));
			}*/
			 
			if(parseInt(to_value)<parseInt(from_value)) {
				error = 1;
			}
		}
		return error;
	}
	function checkSlotTimes() {
		var error = 0;
		var len = document.getElementsByName('slot_time_from_hour[]').length;
		for(i=0;i<len;i++) {
			tempMinuteFrom = document.getElementsByName("slot_time_from_minute[]").item(i).value;
			if(document.getElementsByName("slot_time_from_minute[]").item(i).value.length == 1) {
				tempMinuteFrom = '0'+document.getElementsByName("slot_time_from_minute[]").item(i).value;
			}
			tempMinuteTo = document.getElementsByName("slot_time_to_minute[]").item(i).value;
			if(document.getElementsByName("slot_time_to_minute[]").item(i).value.length == 1) {
				tempMinuteTo = '0'+document.getElementsByName("slot_time_to_minute[]").item(i).value;
				
			}
			
			var from_value =document.getElementsByName("slot_time_from_hour[]").item(i).value+""+tempMinuteFrom;
			var to_value =document.getElementsByName("slot_time_to_hour[]").item(i).value+""+tempMinuteTo;
			if(document.getElementsByName("slot_time_from_ampm[]").item(i) && document.getElementsByName("slot_time_from_ampm[]").item(i).value=='am') {
				switch(document.getElementsByName("slot_time_from_hour[]").item(i).value) {
					case '12':
						from_value = '00'+tempMinuteFrom;
						break;
				}
			} else if(document.getElementsByName("slot_time_from_ampm[]").item(i) && document.getElementsByName("slot_time_from_ampm[]").item(i).value=='pm') {
				switch(document.getElementsByName("slot_time_from_hour[]").item(i).value) {
					case '1':
						from_value = '13'+tempMinuteFrom;
						break;
					case '2':
						from_value = '14'+tempMinuteFrom;
						break;
					case '3':
						from_value = '15'+tempMinuteFrom;
						break;
					case '4':
						from_value = '16'+tempMinuteFrom;
						break;
					case '5':
						from_value = '17'+tempMinuteFrom;
						break;
					case '6':
						from_value = '18'+tempMinuteFrom;
						break;
					case '7':
						from_value = '19'+tempMinuteFrom;
						break;
					case '8':
						from_value = '20'+tempMinuteFrom;
						break;
					case '9':
						from_value = '21'+tempMinuteFrom;
						break;
					case '10':
						from_value = '22'+tempMinuteFrom;
						break;
					case '11':
						from_value = '23'+tempMinuteFrom;
						break;
				}
			}
			if(document.getElementsByName("slot_time_to_ampm[]").item(i) && document.getElementsByName("slot_time_to_ampm[]").item(i).value=='am') {
				switch(document.getElementsByName("slot_time_to_hour[]").item(i).value) {
					case '12':
						to_value = '00'+tempMinuteTo;
						break;
				}
			} else if(document.getElementsByName("slot_time_to_ampm[]").item(i) && document.getElementsByName("slot_time_to_ampm[]").item(i).value=='pm') {
				switch(document.getElementsByName("slot_time_to_hour[]").item(i).value) {
					case '1':
						to_value = '13'+tempMinuteTo;
						break;
					case '2':
						to_value = '14'+tempMinuteTo;
						break;
					case '3':
						to_value = '15'+tempMinuteTo;
						break;
					case '4':
						to_value = '16'+tempMinuteTo;
						break;
					case '5':
						to_value = '17'+tempMinuteTo;
						break;
					case '6':
						to_value = '18'+tempMinuteTo;
						break;
					case '7':
						to_value = '19'+tempMinuteTo;
						break;
					case '8':
						to_value = '20'+tempMinuteTo;
						break;
					case '9':
						to_value = '21'+tempMinuteTo;
						break;
					case '10':
						to_value = '22'+tempMinuteTo;
						break;
					case '11':
						to_value = '23'+tempMinuteTo;
						break;
				}
			}
			
			/*if(from_value.substring(0,1) == "0") {
				from_value = parseInt(from_value.substring(1,4));
			}
			if(to_value.substring(0,1) == "0") {
				to_value = parseInt(to_value.substring(1,4));
			}*/
			
			if(parseInt(to_value)<parseInt(from_value)) {
				error = 1;
			}
			
			
		}
		
		return error;
	}
	function checkData(frm) {
		
		with(frm) {
			if(slot_date_from.value=='') {
				alert("<?php echo addslashes($langObj->getLabel("SLOT_DATE_FROM_ALERT")); ?>");
				return false;
			} else if(slot_interval.options[slot_interval.selectedIndex].value == '') {
				alert("<?php echo addslashes($langObj->getLabel("SLOT_INTERVAL_CHOOSE_ALERT")); ?>");
				return false;
			} else if(slot_interval.options[slot_interval.selectedIndex].value == '1' && (!isNumeric(slot_interval_minutes) || slot_interval_minutes.value>1435)) {
				alert("<?php echo addslashes($langObj->getLabel("SLOT_INTERVAL_ALERT")); ?>");
				return false;
			} else if(slot_interval.options[slot_interval.selectedIndex].value == '0' && (document.getElementsByName("slot_interval_custom_from_hour[]").item(0).value=='' || document.getElementsByName("slot_interval_custom_to_hour[]").item(0).value=='')) {
				alert("<?php echo addslashes($langObj->getLabel("SLOT_CUSTOM_SLOT_ALERT")); ?>");
				return false;
			} else if(slot_interval.options[slot_interval.selectedIndex].value == '0' && checkSlotIntervalCustomTimes()==1) {				
				alert("<?php echo addslashes($langObj->getLabel("SLOT_SLOT_DURATION_ALERT")); ?>");
				return false;
			} else if(slot_pause.value != '0' && slot_pause.value!= '' && (!isNumeric(slot_pause) || slot_pause.value<5 || slot_pause.value>1435)) {
				alert("<?php echo addslashes($langObj->getLabel("SLOT_SLOT_PAUSE_ALERT")); ?>");
				return false;
			} else if(slot_interval.options[slot_interval.selectedIndex].value == '1' && (document.getElementsByName("slot_time_from_hour[]").item(0).value=='' || document.getElementsByName("slot_time_to_hour[]").item(0).value=='')) {
				alert("<?php echo addslashes($langObj->getLabel("SLOT_TIME_FROM_TIME_TO_ALERT")); ?>");
				return false;
			} else if(slot_interval.options[slot_interval.selectedIndex].value == '1' && checkSlotTimes() == 1) {
				alert("<?php echo addslashes($langObj->getLabel("SLOT_TIME_PERIOD_ALERT")); ?>");
				return false;
			} else {
				$('body').prepend('<div id="sfondo" class="modal_sfondo"><div id="modal_loading" class="modal_loading"><img src="images/loading.png" border=0 /></div></div>');
				return true;
			}
		}
	}

    function showDiscountedPrice(val) {
        if(val == 1) {
            $('#discounted_price').fadeIn();
        } else {
            $('#discounted_price').fadeOut();
        }
    }

    function showPercOrDiscount(val) {
        if(val == 'perc') {
            $('#perc_price').fadeIn();
            $('#discount_price').fadeOut(0);
        } else {
            $('#discount_price').fadeIn();
            $('#perc_price').fadeOut(0);
        }
        $('#show_price').fadeIn();
    }
</script>

<div id="form_container">
	<div id="label_input">
        <div class="label_title"><label for="slot_date_from"><?php echo $langObj->getLabel("SLOT_TITLE"); ?></label></div>
	<div class="label_subtitle font_14 mark_red line_20"><?php echo $langObj->getLabel("SLOT_SUBTITLE"); ?></div>
    </div>
	<div id="rowspace"></div>
    <div id="rowline"></div>
    <div id="rowspace"></div>
<form name="addslot" action="" method="post" onsubmit="return checkData(this);">
    <input type="hidden" name="calendar_id" value="<?php echo $_GET["calendar_id"]; ?>" />
    
    <!-- 
    =======================
    === Creation date ==
    =======================
    -->
    <div id="label_input">
        <div class="label_title"><label for="slot_date_from"><?php echo $langObj->getLabel("SLOT_DATE_LABEL"); ?></label></div>
    </div>
    <div class="input_boxes_container">
    	<div class="input_title"><?php echo $langObj->getLabel("SLOTS_FROM"); ?></div>
        <div class="input_input">
        	<input type="text" class="short_input_box" name="slot_date_from" id="slot_date_from" readonly="readonly">
            <input type="hidden" name="first_date" id="first_date">
        </div>
        
        <div class="input_title"><?php echo $langObj->getLabel("SLOTS_TO"); ?></div>
        <div class="input_input">
            <input type="text" class="short_input_box" name="slot_date_to" id="slot_date_to"  readonly="readonly">&nbsp;<input type="button" id="delete_button" style="display:none" value="<?php echo $langObj->getLabel("SLOTS_DELETE"); ?>" onclick="javascript:clearDateTo();" />
            <input type="hidden" name="second_date" id="second_date">
            <div class="input_input_subtitle"><?php echo $langObj->getLabel("SLOT_DATE_TO_SUBLABEL"); ?></div>
        </div>
    
    </div>
    <div id="rowspace"></div>
    <div id="rowline"></div>
    <div id="rowspace"></div>
    
    <!-- 
    =======================
    ===  ==
    =======================
    -->
    <div id="weekday_div" style="display:none">
        <div id="label_input">
            <div class="label_title"><label for="slot_weekday"><?php echo $langObj->getLabel("SLOT_WEEKDAY_LABEL"); ?></label></div>
        </div>
        <div id="input_box">
            <input type="checkbox" name="selectAll" id="slot_weekday" value="0" onclick="javascript:selectCheckbox('addslot','slot_weekday[]');" checked="checked">&nbsp;<?php echo $langObj->getLabel("SLOT_WEEKDAY_ALL"); ?><br>
            <input type="checkbox" name="slot_weekday[]" id="slot_weekday" value="1" onclick="javascript:disableSelectAll('addslot',this.checked);" checked="checked">&nbsp;<?php echo $langObj->getLabel("SLOT_WEEKDAY_MON"); ?><br>
            <input type="checkbox" name="slot_weekday[]" id="slot_weekday" value="2" onclick="javascript:disableSelectAll('addslot',this.checked);" checked="checked">&nbsp;<?php echo $langObj->getLabel("SLOT_WEEKDAY_TUE"); ?><br>
            <input type="checkbox" name="slot_weekday[]" id="slot_weekday" value="3" onclick="javascript:disableSelectAll('addslot',this.checked);" checked="checked">&nbsp;<?php echo $langObj->getLabel("SLOT_WEEKDAY_WED"); ?><br>
            <input type="checkbox" name="slot_weekday[]" id="slot_weekday" value="4" onclick="javascript:disableSelectAll('addslot',this.checked);" checked="checked">&nbsp;<?php echo $langObj->getLabel("SLOT_WEEKDAY_THU"); ?><br>
            <input type="checkbox" name="slot_weekday[]" id="slot_weekday" value="5" onclick="javascript:disableSelectAll('addslot',this.checked);" checked="checked">&nbsp;<?php echo $langObj->getLabel("SLOT_WEEKDAY_FRI"); ?><br>
            <input type="checkbox" name="slot_weekday[]" id="slot_weekday" value="6" onclick="javascript:disableSelectAll('addslot',this.checked);" checked="checked">&nbsp;<?php echo $langObj->getLabel("SLOT_WEEKDAY_SAT"); ?><br>
            <input type="checkbox" name="slot_weekday[]" id="slot_weekday" value="7" onclick="javascript:disableSelectAll('addslot',this.checked);" checked="checked">&nbsp;<?php echo $langObj->getLabel("SLOT_WEEKDAY_SUN"); ?>
        </div>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
    </div>
    <!-- 
    =======================
    === Slot duration  ==
    =======================
    -->
   <div id="label_input">
        <div class="label_title"><label for="slot_interval"><?php echo $langObj->getLabel("SLOT_DURATION_LABEL"); ?></label></div>
        <div class="label_subtitle"><?php echo $langObj->getLabel("SLOT_DURATION_SUBLABEL"); ?></div>
    </div>
    
    <div id="input_box">
        <select name="slot_interval" id="slot_interval" onChange="javascript:showCustom(this.options[this.selectedIndex].value);" >
        	<option value=""><?php echo $langObj->getLabel("SLOT_DURATION_CHOOSE"); ?></option>
        	<option value="1"><?php echo $langObj->getLabel("SLOT_DURATION_MINUTES"); ?></option>
            <option value="0"><?php echo $langObj->getLabel("SLOT_DURATION_FROM_TO"); ?></option>
        </select>
         <!-- if from to  -->
        <div id="custom_fields" style="display:none;margin-top:20px">
		<div class="label_subtitle margin_b_10"><?php echo $langObj->getLabel("SLOT_CUSTOM_TIME_LABEL"); ?></div>
		<div id="custom_fields_add">
				<?php echo $langObj->getLabel("SLOTS_FROM"); ?>&nbsp;
                <select name="slot_interval_custom_from_hour[]" style="width:70px">
                    <option value=""><?php echo $langObj->getLabel("SLOTS_HOUR"); ?></option>
                    <?php
                    if($settingObj->getTimeFormat() == '24') {
						$start=0;
                        $to = 23;
                        $ampm=0;
                    } else {
						$start=1;
                        $to = 12;
                        $ampm = 1;
                    }
                    for($i=$start;$i<=$to;$i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <select name="slot_interval_custom_from_minute[]" style="width:70px">
                    <option value=""><?php echo $langObj->getLabel("SLOTS_MINUTE"); ?></option>
                    <?php						
                    for($i=0;$i<=59;$i++) {
						$num = $i;
						if(strlen($num) == 1) {
							$num = '0'.$num;
						}
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $num; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php
                if($ampm == 1) {
                    ?>
                    <select name="slot_interval_custom_from_ampm[]" style="width:70px">
                        <option value="am">am</option>
                        <option value="pm">pm</option>
                    </select>
                    <?php
                }
                ?>
                &nbsp;
                &nbsp;
				<?php echo $langObj->getLabel("SLOTS_TO"); ?>&nbsp;
                <select name="slot_interval_custom_to_hour[]" style="width:70px">
                    <option value=""><?php echo $langObj->getLabel("SLOTS_HOUR"); ?></option>
                    <?php
                    if($settingObj->getTimeFormat() == '24') {
						$start=0;
                        $to = 23;
                        $ampm=0;
                    } else {
						$start=1;
                        $to = 12;
                        $ampm = 1;
                    }
                    for($i=$start;$i<=$to;$i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <select name="slot_interval_custom_to_minute[]" style="width:70px">
                    <option value=""><?php echo $langObj->getLabel("SLOTS_MINUTE"); ?></option>
                    <?php						
                    for($i=0;$i<=59;$i++) {
						$num = $i;
						if(strlen($num) == 1) {
							$num = '0'.$num;
						}
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $num; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php
                if($ampm == 1) {
                    ?>
                    <select name="slot_interval_custom_to_ampm[]" style="width:70px">
                        <option value="am">am</option>
                        <option value="pm">pm</option>
                    </select>
                    <?php
                }
                ?>
                
            </div>
            <br /><input type="button" id="add_time" value="+" onClick="javascript:addTime(1);">
        </div>
          <!-- if in minutes  -->
        <div id="custom_minutes" style="display:none;margin-top:20px"><?php echo $langObj->getLabel("SLOT_INTERVAL_LABEL"); ?>&nbsp;<input type="text" name="slot_interval_minutes" id="slot_interval_minutes" class="custom_fields short_input_box" style="width:300px" ></div>
        
        
    </div>
    <div id="rowspace"></div>
    <div id="rowline"></div>
    <div id="rowspace"></div>
    
    <!-- 
    =======================
    === Pause management  ==
    =======================
    -->
    <div id="label_input">
        <div class="label_title"><label for="slot_pause"><?php echo $langObj->getLabel("SLOT_PAUSE_LABEL"); ?></label></div>
        <div class="label_subtitle"><?php echo $langObj->getLabel("SLOT_PAUSE_SUBLABEL"); ?></div>
    </div>
    <div id="input_box">
        <input type="text" name="slot_pause" value="0" />
      </div>
      <div id="rowspace"></div>
    <div id="rowline"></div>
    <div id="rowspace"></div>
    
    <!-- 
    =======================
    === Range time ==
    =======================
    -->
    <div id="range_time">
        <div id="label_input">
            <div class="label_title"><label for="slot_time_from"><?php echo $langObj->getLabel("SLOT_TIME_LABEL"); ?></label></div>
            <div class="label_subtitle"><?php echo $langObj->getLabel("SLOT_TIME_SUBLABEL"); ?><br /><?php echo $langObj->getLabel("SLOT_CUSTOM_TIME_LABEL"); ?></div>
        </div>
        
          <div class="margin_t_10 font_12" id="time_ranges">
        	<div id="time_ranges_add">
                <div class="float_left margin_t_12"><?php echo $langObj->getLabel("SLOTS_FROM"); ?></div>
                <div class="float_left margin_l_10 margin_t_10">
                	<select name="slot_time_from_hour[]" class="margin_t_5">
                    	<option value=""><?php echo $langObj->getLabel("SLOTS_HOUR"); ?></option>
                        <?php
						if($settingObj->getTimeFormat() == '24') {
							$start=0;
							$to = 23;
							$ampm=0;
						} else {
							$start=1;
							$to = 12;
							$ampm = 1;
						}
						for($i=$start;$i<=$to;$i++) {
							?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
						}
						?>
                    </select>
                    <select name="slot_time_from_minute[]" class="margin_t_5">
                    	<option value=""><?php echo $langObj->getLabel("SLOTS_MINUTE"); ?></option>
                        <?php						
						for($i=0;$i<=59;$i++) {
							$num = $i;
							if(strlen($num) == 1) {
								$num = '0'.$num;
							}
							?>
                            <option value="<?php echo $i; ?>"><?php echo $num; ?></option>
                            <?php
						}
						?>
                    </select>
                    <?php
					if($ampm == 1) {
						?>
                        <select name="slot_time_from_ampm[]" class="margin_t_5">
                            <option value="am">am</option>
                            <option value="pm">pm</option>
                        </select>
                        <?php
					}
					?>
                	
               	</div>
                
                <div class="float_left margin_t_12 margin_l_20"><?php echo $langObj->getLabel("SLOTS_TO"); ?></div>
                <div class="float_left margin_l_10 margin_t_10">
                	<select name="slot_time_to_hour[]" class="margin_t_5">
                    	<option value=""><?php echo $langObj->getLabel("SLOTS_HOUR"); ?></option>
                        <?php
						if($settingObj->getTimeFormat() == '24') {
							$start=0;
							$to = 23;
							$ampm=0;
						} else {
							$start=1;
							$to = 12;
							$ampm = 1;
						}
						for($i=$start;$i<=$to;$i++) {
							?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
						}
						?>
                    </select>
                    <select name="slot_time_to_minute[]" class="margin_t_5">
                    	<option value=""><?php echo $langObj->getLabel("SLOTS_MINUTE"); ?></option>
                        <?php						
						for($i=0;$i<=59;$i++) {
							$num = $i;
							if(strlen($num) == 1) {
								$num = '0'.$num;
							}
							?>
                            <option value="<?php echo $i; ?>"><?php echo $num; ?></option>
                            <?php
						}
						?>
                    </select>
                    <?php
					if($ampm == 1) {
						?>
                        <select name="slot_time_to_ampm[]" class="margin_t_5">
                            <option value="am">am</option>
                            <option value="pm">pm</option>
                        </select>
                        <?php
					}
					?>
                	
                </div>
                <div class="cleardiv"></div>
            </div>
            <div class="margin_t_20"><input type="button" id="add_time_range" value="+" onClick="javascript:addTimeRange(1);" /></div>
            
        </div>
        
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
    </div>  
    
    <!-- 
    =======================
    === special text management  ==
    =======================
    -->
    <div id="label_input">
        <div class="label_title"><label for="special_text"><?php echo $langObj->getLabel("SLOT_SPECIAL_LABEL"); ?></label></div>
    </div>
    <div id="input_box">
    	<input type="text" name="special_text" id="special_text" /><br />
        <select name="special_mode" id="special_mode" style="width: 250px;">
        	<option value="1" selected><?php echo $langObj->getLabel("SLOT_SPECIAL_MODE_BOTH"); ?></option>
            <option value="0"><?php echo $langObj->getLabel("SLOT_SPECIAL_MODE_TEXT"); ?></option>
        </select>
      </div>
      <div id="rowspace"></div>
    <div id="rowline"></div>
    <div id="rowspace"></div>
    <!-- 
    ========================
    === Price management  ==
    ========================
    -->
    
    <div id="label_input">
        <div class="label_title"><label for="slot_price"><?php echo $langObj->getLabel("SLOT_PRICE_LABEL"); ?></label></div>
        <div class="label_subtitle"><?php echo $langObj->getLabel("SLOT_PRICE_SUBLABEL"); ?></div>
    </div>
    <div id="input_box">
        <input type="text" name="slot_price" value="0" /><?php echo $settingObj->getPaypalCurrency(); ?>
      </div>

    <?php
    //if Paypal is active, I need to ask if they want people to pay only a percentage of the price or a discounted price
    if($settingObj->getPaypal()==1 && $settingObj->getPaypalAccount() != '' && $settingObj->getPaypalLocale() != '' && $settingObj->getPaypalCurrency() != '') {
        ?>
        <div id="label_input" class="margin_t_20">
            <div class="label_title"><label for="slot_show_different_price"><?php echo $langObj->getLabel("SLOT_SHOW_DIFFERENT_PRICE_LABEL"); ?></label></div>
        </div>
        <div id="input_box">
            <input type="radio" name="slot_show_different_price" value="1" />&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_YES"); ?>&nbsp;<input type="radio" name="slot_show_different_price" value="0" checked/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_NO"); ?>
        </div>

        <div class="cleardiv"></div>
        <div id="discounted_price" style="display: none">
            <div id="label_input">
                <div class="label_title"><label for="slot_perc_or_discount"><?php echo $langObj->getLabel("SLOT_PERC_OR_DISCOUNT_LABEL"); ?> <?php echo $settingObj->getPaypalCurrency(); ?></label></div>
            </div>
            <div id="input_box">
                <input type="radio" name="slot_perc_or_discount" value="perc" />&nbsp;<?php echo $langObj->getLabel("SLOT_PERCENTAGE"); ?>&nbsp;<input type="radio" name="slot_perc_or_discount" value="discount" checked/>&nbsp;<?php echo $langObj->getLabel("SLOT_DISCOUNT"); ?> <?php echo $settingObj->getPaypalCurrency(); ?>
            </div>

            <div class="cleardiv"></div>
            <div id="perc_price" style="display: none">
                <div id="input_box">
                    <input type="text" name="slot_perc_price" value="0" />%
                </div>
            </div>
            <div id="discount_price">
                <div id="input_box">
                    <input type="text" name="slot_discount_price" value="0" /><?php echo $settingObj->getPaypalCurrency(); ?>
                </div>
            </div>
        </div>
        <div id="show_price" style="display: none">
            <div id="label_input">
                <div class="label_title"><label for="slot_show_price"><?php echo $langObj->getLabel("SLOT_SHOW_PRICE"); ?></label></div>
            </div>
            <div id="input_box">
                <select name="slot_show_price" id="slot_show_price" style="width: 250px;">
                    <option value="0"><?php echo $langObj->getLabel("SLOT_SHOW_ONLY_FULL_PRICE"); ?></option>
                    <option value="1"><?php echo $langObj->getLabel("SLOT_SHOW_ONLY_DISCOUNT_PRICE"); ?></option>
                    <option value="2" selected><?php echo $langObj->getLabel("SLOT_SHOW_BOTH_PRICES"); ?></option>
                </select>
            </div>

        </div>
    <?php
    }
    ?>
      <div id="rowspace"></div>
    <div id="rowline"></div>
    <div id="rowspace"></div>
	
    
     <!-- 
    ========================
    === Seats management  ==
    ========================
    -->
    <?php
	if($settingObj->getSlotsUnlimited() == 2) {
	?>
    <script>
		function fillAvMax(string) {
			$('#slot_av_max').val(string);
		}
	</script>
    <div id="label_input">
        <div class="label_title"><label for="slot_av"><?php echo $langObj->getLabel("SLOT_AV_LABEL"); ?></label></div>
        <div class="label_subtitle"><?php echo $langObj->getLabel("SLOT_AV_SUBLABEL"); ?></div>
    </div>
    <div id="input_box">
        <input type="text" name="slot_av" value="0" onkeyup="javascript:fillAvMax(this.value);" />
      </div>
      <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
    <div id="label_input">
        <div class="label_title"><label for="slot_av"><?php echo $langObj->getLabel("SLOT_AV_MAX_LABEL"); ?></label></div>
        <div class="label_subtitle"><?php echo $langObj->getLabel("SLOT_AV_MAX_SUBLABEL"); ?></div>
    </div>
    <div id="input_box">
        <input type="text" name="slot_av_max" id="slot_av_max" value="0" />
      </div>
      <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
	<?php
    }
    ?>
    
    <!-- bridge buttons -->
    <div class="bridge_buttons_container">
        <!-- cancel -->
        <div ><a href="javascript:document.location.href='calendar_manage.php?calendar_id=<?php echo $_GET["calendar_id"]; ?>&ref=slots';" class="cancel_button"><?php echo $langObj->getLabel("SLOT_CANCEL_BUTTON"); ?></a></div>
        
        <!-- save -->
        <div style="margin-left:740px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("SLOT_SAVE_BUTTON"); ?>"></div>
        <div id="loading" style="float:left;margin-top:30px;margin-left:10px"></div>
    </div>
    <div id="rowspace"></div>
    
    </form>
    
 </div>

        
      
