<?php 
$arraySlotsHour = $listObj->getSlotsHoursList($_GET["calendar_id"]);
?>


<?php
/***if there are slots I show the management to delete/modify them***/
if(count($arraySlotsHour)>0) {
?>
	<script>
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
			$( "#date_to_delete").datepicker({
				altField: "#second_date_delete",
				altFormat: "yy,mm,dd",
				onClose: function( selectedDate ) {
					$( "#date_from_delete" ).datepicker( "option", "maxDate", selectedDate );
				}
			});
			$( "#date_from_delete").datepicker({
				altField: "#first_date_delete",
				altFormat: "yy,mm,dd",
				minDate: new Date(),
				
				
				onClose: function( selectedDate ) {
					$( "#date_to_delete" ).datepicker( "option", "minDate", selectedDate );
					$( "#date_to_delete").datepicker({
						altField: "#second_date_delete",
						altFormat: "yy,mm,dd",
						//minDate: selectedDate,
						onClose: function( selectedDate ) {
							$( "#date_from_delete" ).datepicker( "option", "maxDate", selectedDate );
						}
					});
					
				}
	
			});
			
			$( "#date_to_edit").datepicker({
				altField: "#second_date_edit",
				altFormat: "yy,mm,dd",
				onClose: function( selectedDate ) {
					$( "#date_from_edit" ).datepicker( "option", "maxDate", selectedDate );
				}
			});
			$( "#date_from_edit").datepicker({
				altField: "#first_date_edit",
				altFormat: "yy,mm,dd",
				minDate: new Date(),
				onClose: function(selectedDate) { 
					$( "#date_to_edit" ).datepicker( "option", "minDate", selectedDate );
					$( "#date_to_edit").datepicker({
						altField: "#second_date_edit",
						altFormat: "yy,mm,dd",
						//minDate: selectedDate,
						onClose: function( selectedDate ) {
							$( "#date_from_edit" ).datepicker( "option", "maxDate", selectedDate );
						}
					});
				}
	
			});
			
			
			
			
			
			
			
		});
		function openSection(div) {
			if(document.getElementById(div).style.display=="none") {
				$('#'+div).slideDown();
			} else {
				$('#'+div).slideUp();
			}
		}
	</script>
    
   
<?php
}
?>

<!-- 
============================================================================================
=== management slots buttons ==
============================================================================================
-->

<!-- 
=======================
=== create slots ==
=======================
-->
<div class="manage_slot_box_container">
    <div class="manage_slot_box_title"><a href="javascript:showPage('new_slot');"><?php echo $langObj->getLabel("CREATE_TIME_SLOTS"); ?></a></div>
</div>

<!-- 
=======================
=== search slots ==
=======================
-->
<script>
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
		$( "#date_to").datepicker({
			altField: "#second_date",
			altFormat: "yy,mm,dd",
			onClose: function( selectedDate ) {
				$( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		$( "#date_from").datepicker({
			altField: "#first_date",
			altFormat: "yy,mm,dd",
			minDate: new Date(),
			onClose: function(selectedDate) { 
				$( "#date_to" ).datepicker( "option", "minDate", selectedDate );
				$( "#date_to").datepicker({
					altField: "#second_date",
					altFormat: "yy,mm,dd",
					//minDate: selectedDate,
					onClose: function( selectedDate ) {
						$( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
					}
				});
			}
		});
		
		
	});
	function filterSlots() {
		if($("#search_date option:selected").val()==1) {
			
			if(Trim($('#first_date').val()) != '') {
				$('#result_search').html('<img src="images/loading.gif">');
				$.ajax({
				  url: 'ajax/filterSlots.php?search_date=1&date_from='+$('#first_date').val()+"&time_from="+$('#time_from_hour').val()+":"+$('#time_from_minute').val()+":"+$('#time_from_ampm').val()+"&time_to="+$('#time_to_hour').val()+":"+$('#time_to_minute').val()+":"+$('#time_to_ampm').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>&pag=1",
				  success: function(data) {
					  /*$('#date_from').val('');
					  $('#time_from').val('');
					  $('#time_to').val('');
					  $('#first_date').val('');*/
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
			  url: 'ajax/filterSlots.php?search_date=2&date_from='+$('#first_date').val()+"&weekday="+$('#slot_week_day').val()+"&date_to="+$('#second_date').val()+"&time_from="+$('#time_from_hour').val()+":"+$('#time_from_minute').val()+":"+$('#time_from_ampm').val()+"&time_to="+$('#time_to_hour').val()+":"+$('#time_to_minute').val()+":"+$('#time_to_ampm').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>&pag=1",
			  success: function(data) {
				  /*$('#date_from').val('');
				  $('#date_to').val('');
				  $('#first_date').val('');
				  $('#second_date').val('');
				  $('#slot_week_day').val("0");
				  $('#time_from').val('');
				  $('#time_to').val('');*/
				 $('#table').hide().html(data).fadeIn(2000);
				 $('#result_search').html('');
				 goToByScroll("results");
			  }
			});
		} else {
			alert("<?php echo addslashes($langObj->getLabel("SLOTS_SELECT_RANGE_ALERT")); ?>");
		}
	}
	
	function showFilters(value) {
		if(value==1) {
			$('#filters').slideDown();
			$('#label_from').html("<?php echo addslashes($langObj->getLabel("SLOTS_DAY")); ?>");
			$('#date_to_filter').slideUp();
			$('#weekdays_filter').slideUp();
		} else if(value==2) {
			$('#filters').slideDown();
			$('#label_from').html("<?php echo addslashes($langObj->getLabel("SLOTS_FROM")); ?>");
			$('#date_to_filter').slideDown();
			$('#weekdays_filter').slideDown();
		} else {
			$('#filters').slideUp();
		}
	}
		
		////end search
	
	function showForm(value) {
		if(value==1) {
			$('#delete_form').fadeOut(0);
			$('#modify_form').slideDown();
			
		} else if(value==2) {
			$('#modify_form').fadeOut(0);
			$('#delete_form').slideDown();
		} else {
			$('#delete_form').slideUp();
			$('#modify_form').slideUp();
		}
	}
	
	function orderby(column,type) {
	
		$.ajax({
		  url: 'ajax/setSlotsOrderby.php?order_by='+column+'&type='+type+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
		  success: function(data) {
			  $('#table').hide().html(data).fadeIn(2000);						 
			
		  }
		});
		
	}
	
	
	function delItem(itemId,reservation) {
		if(confirm("<?php echo addslashes($langObj->getLabel("SLOTS_DELETE_SINGLE_ALERT")); ?>")) {
			$('body').prepend('<div id="sfondo" class="modal_sfondo"><div id="modal_loading" class="modal_loading"><img src="images/loading.png" border=0 /></div></div>');
			$.ajax({
			  url: 'ajax/delSlotsItem.php?item_id='+itemId+"&reservation="+reservation+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
			  success: function(data) {
				  $('#sfondo').remove();
				  $('#table').hide().html(data).fadeIn(2000);
				 goToByScroll("results");
				
			  }
			});
		} 
	}
	function editItem(slot) {
		$('#modify_'+slot).html('<a href="javascript:saveItem('+slot+');"><?php echo addslashes($langObj->getLabel("CALENDARS_SAVE")); ?></a>');
		$('#text_display_'+slot).fadeOut(0);
		$('#price_display_'+slot).fadeOut(0);
		$('#av_display_'+slot).fadeOut(0);
		$('#av_max_display_'+slot).fadeOut(0);
		$('#time_from_display_'+slot).fadeOut(0);
		$('#time_to_display_'+slot).fadeOut(0);
		$('#date_display_'+slot).fadeOut(0);
		
		$('#text_input_'+slot).fadeIn(0);
		$('#price_input_'+slot).fadeIn(0);
		$('#av_input_'+slot).fadeIn(0);
		$('#av_max_input_'+slot).fadeIn(0);
		$('#time_from_input_'+slot).fadeIn(0);
		$('#time_to_input_'+slot).fadeIn(0);
		$('#date_input_'+slot).fadeIn(0);
		
		
		$('#slot_date_'+slot).datepicker({
			altField: "#date_value_"+slot,
			altFormat: "yy-mm-dd",
			minDate: new Date(),
		});
		
			
		
		
		
	}
	function checkEditInLineTimes() {
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
	function saveItem(slot) {
		if(Trim($('#slot_date_'+slot).val()) != '' && Trim($('#slot_time_from_hour_'+slot).val()) != '' && Trim($('#slot_time_from_minute_'+slot).val()) != '' && Trim($('#slot_time_to_hour_'+slot).val()) != '' && Trim($('#slot_time_to_minute_'+slot).val()) != '') {
			if($('#slot_special_text_'+slot).val()!=undefined) {
				new_text = $('#slot_special_text_'+slot).val();
			} else {
				new_text = "";
			}
			if($('#slot_price_'+slot).val()!=undefined) {
				newprice = $('#slot_price_'+slot).val();
			} else {
				newprice = "";
			}
			if($('#slot_av_'+slot).val()!=undefined) {
				newav = $('#slot_av_'+slot).val();
			} else {
				newav = "";
			}
			if($('#slot_av_max_'+slot).val()!=undefined) {
				newavmax = $('#slot_av_max_'+slot).val();
			} else {
				newavmax = "";
			}
			$.ajax({
			  url: 'ajax/saveSlot.php?item_id='+slot+"&date="+$('#date_value_'+slot).val()+"&time_from="+$('#slot_time_from_hour_'+slot).val()+":"+$('#slot_time_from_minute_'+slot).val()+":"+$('#slot_time_from_ampm_'+slot).val()+"&time_to="+$('#slot_time_to_hour_'+slot).val()+":"+$('#slot_time_to_minute_'+slot).val()+":"+$('#slot_time_to_ampm_'+slot).val()+"&text="+new_text+"&price="+newprice+"&av="+newav+"&avmax="+newavmax,
			  success: function(data) {
				  if(data == 0) {
					  alert("<?php echo addslashes($langObj->getLabel("SLOTS_DUPLICATE_SLOT_ALERT")); ?>");
				  } else {
					  $('#time_from_display_'+slot).fadeIn(0);
					  $('#time_to_display_'+slot).fadeIn(0);
					  $('#date_display_'+slot).fadeIn(0);
					  $('#text_display_'+slot).fadeIn(0);
					  $('#price_display_'+slot).fadeIn(0);
					  $('#av_display_'+slot).fadeIn(0);
					  $('#av_max_display_'+slot).fadeIn(0);
					  
					  $('#time_from_input_'+slot).fadeOut(0);
					  $('#time_to_input_'+slot).fadeOut(0);
					  $('#date_input_'+slot).fadeOut(0);
					  $('#text_input_'+slot).fadeOut(0);
					  $('#price_input_'+slot).fadeOut(0);
					  $('#av_input_'+slot).fadeOut(0);
					  $('#av_max_input_'+slot).fadeOut(0);
					  
					  $('#date_display_'+slot).html(data);
					  from_hour = $('#slot_time_from_hour_'+slot).val();
					  if(from_hour.length==1) {
						  from_hour='0'+from_hour;
					  }
					  from_minute = $('#slot_time_from_minute_'+slot).val();
					  if(from_minute.length==1) {
						  from_minute='0'+from_minute;
					  }
					  to_hour = $('#slot_time_to_hour_'+slot).val();
					  if(to_hour.length==1) {
						  to_hour='0'+to_hour;
					  }
					  to_minute = $('#slot_time_to_minute_'+slot).val();
					  if(to_minute.length==1) {
						  to_minute='0'+to_minute;
					  }
					  ampm = '';
					  if($('#slot_time_from_ampm_'+slot).val() != undefined) {
						  ampm = $('#slot_time_from_ampm_'+slot).val();
					  }
					  
					  $('#time_from_display_'+slot).html(from_hour+":"+from_minute+" "+ampm);
					  ampm = '';
					  if($('#slot_time_to_ampm_'+slot).val() != undefined) {
						  ampm = $('#slot_time_to_ampm_'+slot).val();
					  }
					  $('#time_to_display_'+slot).html(to_hour+":"+to_minute+" "+ampm);
					  $('#text_display_'+slot).html($('#slot_special_text_'+slot).val());
					  if($('#slot_price_'+slot).val()!='') {
						  var newprice = $('#slot_price_'+slot).val();
					  	  $('#price_display_'+slot).html(parseFloat(newprice).toFixed(2)+' <?php echo $settingObj->getPaypalCurrency(); ?>');
					  } else {
						  $('#price_display_'+slot).html('0.00 <?php echo $settingObj->getPaypalCurrency(); ?>');
					  }
					  if($('#slot_av_'+slot).val()!='') {
						  var newav = $('#slot_av_'+slot).val();
					  	  $('#av_display_'+slot).html(newav);
					  } else {
						  $('#av_display_'+slot).html('');
					  }
					  if($('#slot_av_max_'+slot).val()!='') {
						  var newavmax = $('#slot_av_max_'+slot).val();
					  	  $('#av_max_display_'+slot).html(newavmax);
					  } else {
						  $('#av_max_display_'+slot).html('');
					  }
					  $('#modify_'+slot).html('<a href="javascript:editItem('+slot+');"><?php echo addslashes($langObj->getLabel("SLOTS_MODIFY")); ?></a>');
					  $('#row_'+slot).hide().fadeIn(2000);
				  }
				 
				
			  }
			});
		} else {
			alert("<?php echo addslashes($langObj->getLabel("SLOTS_TIME_ALERT")); ?>");
		}
	}
	
	function goToByScroll(id){
	      $('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
	}
	
	function checkEditTimes() {
		var error = 0;
		var len = document.getElementsByName('time_from_edit_hour[]').length;
		
		for(i=0;i<len;i++) {
			tempMinuteFrom = document.getElementsByName("time_from_edit_minute[]").item(i).value;
			if(document.getElementsByName("time_from_edit_minute[]").item(i).value.length == 1) {
				tempMinuteFrom = '0'+document.getElementsByName("time_from_edit_minute[]").item(i).value;
			}
			tempMinuteTo = document.getElementsByName("time_to_edit_minute[]").item(i).value;
			if(document.getElementsByName("time_to_edit_minute[]").item(i).value.length == 1) {
				tempMinuteTo = '0'+document.getElementsByName("time_to_edit_minute[]").item(i).value;
				
			}
			
			var from_value =document.getElementsByName("time_from_edit_hour[]").item(i).value+""+tempMinuteFrom;
			var to_value =document.getElementsByName("time_to_edit_hour[]").item(i).value+""+tempMinuteTo;
			if(document.getElementsByName("time_from_edit_ampm[]").item(i) && document.getElementsByName("time_from_edit_ampm[]").item(i).value=='am') {
				switch(document.getElementsByName("time_from_edit_hour[]").item(i).value) {
					case '12':
						from_value = '00'+tempMinuteFrom;
						break;
				}
			} else if(document.getElementsByName("time_from_edit_ampm[]").item(i) && document.getElementsByName("time_from_edit_ampm[]").item(i).value=='pm') {
				switch(document.getElementsByName("time_from_edit_hour[]").item(i).value) {
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
			if(document.getElementsByName("time_to_edit_ampm[]").item(i) && document.getElementsByName("time_to_edit_ampm[]").item(i).value=='am') {
				switch(document.getElementsByName("time_to_edit_hour[]").item(i).value) {
					case '12':
						to_value = '00'+tempMinuteTo;
						break;
				}
			} else if(document.getElementsByName("time_to_edit_ampm[]").item(i) && document.getElementsByName("time_to_edit_ampm[]").item(i).value=='pm') {
				switch(document.getElementsByName("time_to_edit_hour[]").item(i).value) {
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
	function checkModifyData(frm) {
		with(frm) {
			if(date_from_edit.value == '') {
				alert("<?php echo addslashes($langObj->getLabel("SLOTS_DATE_FROM_ALERT")); ?>");
				return false;
			} else if(date_to_edit.value== '' ) {
				alert("<?php echo addslashes($langObj->getLabel("SLOTS_DATE_TO_ALERT")); ?>"); 
				return false;
			} else if(checkEditTimes() == 1) {
				alert("<?php echo addslashes($langObj->getLabel("SLOTS_NEW_TIME_RANGE_ALERT")); ?>");
				return false;
			} else {
				return true;
			}
		}
	}
	
</script>
<?php
if(count($arraySlotsHour)>0) {
?>
<div class="manage_slot_box_container">
    <div class="manage_slot_box_title"><a href="javascript:openSection('search_div');"><?php echo $langObj->getLabel("SLOT_SEARCH_TIME_SLOTS_LABEL"); ?></a></div>
    <div class="manage_slot_box_container_inside" id="search_div" style="display:none">
        <div id="label_input">
            <div class="label_subtitle"><?php echo $langObj->getLabel("SLOT_SEARCH_TIME_SLOTS_SUBLABEL"); ?></div>
        </div>
        <!-- select filter by date -->
        <div class="select_container">
            <div class="input_title"><label for="search_date"><?php echo $langObj->getLabel("SLOT_SEARCH_FILTER_LABEL"); ?></label></div>
            <div class="input_input">
                <select name="search_date" id="search_date" class="filter_by_date" onchange="javascript:showFilters(this.options[this.selectedIndex].value);">
                    <option value="0"><?php echo $langObj->getLabel("SLOT_SEARCH_FILTER_CHOOSE"); ?></option>
                    <option value="1"><?php echo $langObj->getLabel("SLOT_SEARCH_FILTER_SINGLE"); ?></option>
                    <option value="2"><?php echo $langObj->getLabel("SLOT_SEARCH_FILTER_PERIOD"); ?></option>
                </select>
            </div>
        </div>
        <div id="filters" style="display:none">
            <div id="empty"></div>
            <!-- filter by period of time -->
            <div class="input_boxes_container">
                <div class="input_title" style="margin-right: 60px;"><label for="date_from" id="label_from"><?php echo $langObj->getLabel("SLOTS_FROM"); ?></label></div>
                <div class="input_input" style="margin-right: 45px;">
                    <input type="text" class="short_input_box" name="date_from" id="date_from" readonly="readonly" >
                    <input type="hidden" name="first_date" id="first_date">
                </div>
                <div id="date_to_filter" style="display:none">
                    <div class="input_title" style="margin-right: 10px;"><label for="date_to"><?php echo $langObj->getLabel("SLOTS_TO"); ?></label></div>
                    <div class="input_input">
                        <input type="text" class="short_input_box" name="date_to" id="date_to"  readonly="readonly">
                        <input type="hidden" name="second_date" id="second_date">
                    </div>
                </div>
            </div>
            <div id="empty"></div>
            <!-- select weekdays -->
            <div class="select_container" style="margin-top: 10px;display:none" id="weekdays_filter" >
                <div class="input_title" style="margin-right: 28px;"><label for="slot_week_day"><?php echo $langObj->getLabel("SLOT_WEEKDAY_LABEL"); ?></label></div>
                <div class="input_input">
                    <select name="slot_week_day" id="slot_week_day" class="filter_by_date">
                        <option value="0"><?php echo $langObj->getLabel("SLOT_WEEKDAY_ALL"); ?></option>
                        <option value="1"><?php echo $langObj->getLabel("SLOT_WEEKDAY_MON"); ?></option>
                        <option value="2"><?php echo $langObj->getLabel("SLOT_WEEKDAY_TUE"); ?></option>
                        <option value="3"><?php echo $langObj->getLabel("SLOT_WEEKDAY_WED"); ?></option>
                        <option value="4"><?php echo $langObj->getLabel("SLOT_WEEKDAY_THU"); ?></option>
                        <option value="5"><?php echo $langObj->getLabel("SLOT_WEEKDAY_FRI"); ?></option>
                        <option value="6"><?php echo $langObj->getLabel("SLOT_WEEKDAY_SAT"); ?></option>
                        <option value="7"><?php echo $langObj->getLabel("SLOT_WEEKDAY_SUN"); ?></option>
                    </select>
                </div>
            </div>
            <div id="empty"></div>
            <!-- filter by range time -->
            <div class="input_boxes_container">
                <div class="input_title" style="margin-right: 28px;"><label for="time_from"><?php echo $langObj->getLabel("SLOT_TIME_FROM_LABEL"); ?></label></div>
                <div class="input_input">
                   <select name="time_from_hour" id="time_from_hour">
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
            <select name="time_from_minute" id="time_from_minute">
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
                <select name="time_from_ampm" id="time_from_ampm">
                    <option value="am">am</option>
                    <option value="pm">pm</option>
                </select>
                <?php
            }
            ?>
                </div>
                
                <div class="input_title"><label for="time_to"><?php echo $langObj->getLabel("SLOT_TIME_TO_LABEL"); ?></label></div>
                <div class="input_input">
                    <select name="time_to_hour" id="time_to_hour">
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
                <select name="time_to_minute" id="time_to_minute">
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
                    <select name="time_to_ampm" id="time_to_ampm">
                        <option value="am">am</option>
                        <option value="pm">pm</option>
                    </select>
                    <?php
                }
                ?>
                    <div class="input_input_subtitle"><?php echo $langObj->getLabel("SLOT_TIME_TO_SUBLABEL"); ?></div>
                </div>
            
            </div>
            <div id="empty"></div>
            
            <!-- search -->
            <div><input type="button" id="search_button" name="saveunpublish" onclick="javascript:filterSlots();" value="<?php echo $langObj->getLabel("SLOT_SEARCH"); ?>"><div id="result_search" style="float:left;margin-top:35px"></div></div>
        	
        </div>
        <div id="rowspace"></div>
    </div>
</div>
<div id="empty"></div>

<!-- 
=======================
=== modify slots ==
=======================
-->
<div class="manage_slot_box_container">
    <div class="manage_slot_box_title"><a href="javascript:openSection('modify_div');"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_LABEL"); ?></a></div>

    <div class="manage_slot_box_container_inside" id="modify_div" style="display:none">
        <div class="select_container" style="margin-top: 10px;" >
            <div class="input_title" style="margin-right: 75px;"><label for="form_action"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_ACTION"); ?></label></div>
            <div class="input_input">
                <select name="form_action" id="form_action" class="filter_by_date" onchange="javascript:showForm(this.options[this.selectedIndex].value);">
                    <option value="0"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_CHOOSE"); ?></option>
                    <option value="1"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_MODIFY"); ?></option>
                    <option value="2"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_DELETE"); ?></option>
                </select>
            </div>
        </div>
         <div id="rowspace"></div>
        <div id="empty"></div>
        <form style="display:none" name="modify_slots" method="post" action="ajax/checkEditSlots.php" target="frame_submit" id="modify_form" onsubmit="return checkModifyData(this);">
            <input type="hidden" name="calendar_id" value="<?php echo $_GET["calendar_id"]; ?>" />
            
            <div class="select_container" style="margin-top: 10px;" >
                <div class="input_title" style="margin-right: 88px;"><label for="slot_hour_edit"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_SLOT"); ?></label></div>
                <div class="input_input">
                    <select name="slot_hour_edit" id="slot_hour_edit" class="filter_by_date">
                        <?php
                        for($i=0;$i<count($arraySlotsHour);$i++) {
				if($settingObj->getTimeFormat() == "12") {
							$slotTime = date('h:i a',strtotime(substr($arraySlotsHour[$i],0,5)));
							
						} else {
							$slotTime = substr($arraySlotsHour[$i],0,5);
							
						}
                            ?>
                            <option value="<?php echo $arraySlotsHour[$i];?>"><?php echo $slotTime; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="empty"></div>
            <!-- select weekdays -->
            <div class="select_container" style="margin-top: 10px;" >
                <div class="input_title" style="margin-right: 52px;"><label for="slot_week_day_edit"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_WEEKDAYS"); ?></label></div>
                <div class="input_input">
                    <select name="slot_week_day_edit" id="slot_week_day_edit" class="filter_by_date">
                        <option value="0"><?php echo $langObj->getLabel("SLOT_WEEKDAY_ALL"); ?></option>
                        <option value="1"><?php echo $langObj->getLabel("SLOT_WEEKDAY_MON"); ?></option>
                        <option value="2"><?php echo $langObj->getLabel("SLOT_WEEKDAY_TUE"); ?></option>
                        <option value="3"><?php echo $langObj->getLabel("SLOT_WEEKDAY_WED"); ?></option>
                        <option value="4"><?php echo $langObj->getLabel("SLOT_WEEKDAY_THU"); ?></option>
                        <option value="5"><?php echo $langObj->getLabel("SLOT_WEEKDAY_FRI"); ?></option>
                        <option value="6"><?php echo $langObj->getLabel("SLOT_WEEKDAY_SAT"); ?></option>
                        <option value="7"><?php echo $langObj->getLabel("SLOT_WEEKDAY_SUN"); ?></option>
                    </select>
                </div>
            </div>
            <div id="empty"></div>
            <div class="input_boxes_container">
                <div class="input_title" style="margin-right: 84px;"><label for="date_from_edit"><?php echo $langObj->getLabel("SLOTS_FROM"); ?></label></div>
                <div class="input_input" style="margin-right: 78px;">
                    <input type="text" class="short_input_box" name="date_from_edit" id="date_from_edit" readonly="readonly">
                    <input type="hidden" name="first_date_edit" id="first_date_edit">
                </div>
               
                <div class="input_title" style="margin-right: 10px;"><label for="date_to_edit"><?php echo $langObj->getLabel("SLOTS_TO"); ?></label></div>
                <div class="input_input">
                    <input type="text" class="short_input_box" name="date_to_edit" id="date_to_edit"  readonly="readonly">
                    <input type="hidden" name="second_date_edit" id="second_date_edit">
                </div>
                
            </div>
            <div id="empty"></div>
             <!-- filter by range time -->
            <div class="input_boxes_container">
                <div class="input_title" style="margin-right: 28px;"><label for="time_from"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_NEW_TIME_FROM"); ?></label></div>
                <div class="input_input">
                   <select name="time_from_edit_hour[]">
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
            <select name="time_from_edit_minute[]">
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
                <select name="time_from_edit_ampm[]">
                    <option value="am">am</option>
                    <option value="pm">pm</option>
                </select>
                <?php
            }
            ?>
        	
                </div>
                
                <div class="input_title"><label for="time_to"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_NEW_TIME_TO"); ?></label></div>
                <div class="input_input">
                    <select name="time_to_edit_hour[]">
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
            <select name="time_to_edit_minute[]">
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
                <select name="time_to_edit_ampm[]">
                    <option value="am">am</option>
                    <option value="pm">pm</option>
                </select>
                <?php
            }
            ?>
        	
                </div>
                
                
				
            
            </div>
            <div id="empty"></div>
            <div class="input_boxes_container">
            	<?php
				if($settingObj->getPaypalDisplayPrice() == 1) {
					?>
                    <div class="input_title" style="margin-right: 58px;"><label for="slot_price_edit"><?php echo $langObj->getLabel("SLOT_MODIFY_NEW_PRICE"); ?></label></div>
                    <div class="input_input">
                        <input type="text" class="short_input_box" name="slot_price_edit" id="slot_price_edit">
                    </div>
					<?php
				}
				?>
            </div>
            <div id="empty"></div>
            <div class="input_boxes_container">
            	<?php
				if($settingObj->getSlotsUnlimited() == 2) {
					?>
                    <div class="input_title" style="margin-right: 58px;"><label for="slot_price_edit"><?php echo $langObj->getLabel("SLOT_MODIFY_NEW_AV"); ?></label></div>
                    <div class="input_input">
                        <input type="text" class="short_input_box" name="slot_av_edit" id="slot_av_edit">
                    </div>
                    <div class="input_title" style="margin-right: 58px;"><label for="slot_price_edit"><?php echo $langObj->getLabel("SLOT_MODIFY_NEW_AV_MAX"); ?></label></div>
                    <div class="input_input">
                        <input type="text" class="short_input_box" name="slot_av_max_edit" id="slot_av_max_edit">
                    </div>
					<?php
				}
				?>
            </div>
            <div id="empty"></div>
            <div class="input_boxes_container">
            	
                <div class="input_title" style="margin-right: 66px;"><label for="slot_price_edit"><?php echo $langObj->getLabel("SLOT_MODIFY_NEW_TEXT"); ?></label></div>
                <div class="input_input">
                    <input type="text" class="short_input_box" name="slot_special_text_edit" id="slot_special_text_edit">
                </div>
                
            </div>
            <div id="empty"></div>
            <!-- search -->
            <div><input type="submit" class="ok_button" id="edit_button" name="saveunpublish" value="OK"></div>
             
            <div id="result_modify"></div> 
            <div id="rowspace"></div>
        </form> 
        <div id="empty"></div>
        <form style="display:none" name="delete_slots" method="post" action="ajax/checkSlots.php" target="frame_submit" tmt:validate="true" id="delete_form">
            <input type="hidden" name="calendar_id" value="<?php echo $_GET["calendar_id"]; ?>" />
            <div class="select_container" style="margin-top: 10px;" >
                <div class="input_title" style="margin-right: 88px;"><label for="slot_hour_delete"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_SLOT"); ?></label></div>
                <div class="input_input">
                    <select name="slot_hour_delete" id="slot_hour_delete" class="filter_by_date">
                        <?php
                        for($i=0;$i<count($arraySlotsHour);$i++) {
				if($settingObj->getTimeFormat() == "12") {
						$slotTime = date('h:i a',strtotime(substr($arraySlotsHour[$i],0,5)));
						
					} else {
						$slotTime = substr($arraySlotsHour[$i],0,5);
						
					}
                            ?>
                            <option value="<?php echo $arraySlotsHour[$i];?>"><?php echo $slotTime; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="empty"></div>
            <!-- select weekdays -->
            <div class="select_container" style="margin-top: 10px;" >
                <div class="input_title" style="margin-right: 52px;"><label for="slot_week_day_delete"><?php echo $langObj->getLabel("SLOT_MODIFY_SLOTS_WEEKDAYS"); ?></label></div>
                <div class="input_input">
                    <select name="slot_week_day_delete" id="slot_week_day_delete" class="filter_by_date">
                        <option value="0"><?php echo $langObj->getLabel("SLOT_WEEKDAY_ALL"); ?></option>
                        <option value="1"><?php echo $langObj->getLabel("SLOT_WEEKDAY_MON"); ?></option>
                        <option value="2"><?php echo $langObj->getLabel("SLOT_WEEKDAY_TUE"); ?></option>
                        <option value="3"><?php echo $langObj->getLabel("SLOT_WEEKDAY_WED"); ?></option>
                        <option value="4"><?php echo $langObj->getLabel("SLOT_WEEKDAY_THU"); ?></option>
                        <option value="5"><?php echo $langObj->getLabel("SLOT_WEEKDAY_FRI"); ?></option>
                        <option value="6"><?php echo $langObj->getLabel("SLOT_WEEKDAY_SAT"); ?></option>
                        <option value="7"><?php echo $langObj->getLabel("SLOT_WEEKDAY_SUN"); ?></option>
                    </select>
                </div>
            </div>
            <div id="empty"></div>
            <div class="input_boxes_container">
                <div class="input_title" style="margin-right: 84px;"><label for="date_from_delete"><?php echo $langObj->getLabel("SLOTS_FROM"); ?></label></div>
                <div class="input_input" style="margin-right: 78px;">
                    <input type="text" class="short_input_box" name="date_from_delete" id="date_from_delete" readonly="readonly"  tmt:required="true" tmt:message="Select a date from">
                    <input type="hidden" name="first_date_delete" id="first_date_delete">
                </div>
               
                <div class="input_title" style="margin-right: 10px;"><label for="date_to_edit"><?php echo $langObj->getLabel("SLOTS_TO"); ?></label></div>
                <div class="input_input">
                    <input type="text" class="short_input_box" name="date_to_delete" id="date_to_delete"  readonly="readonly" tmt:required="true" tmt:message="Select a date to">
                    <input type="hidden" name="second_date_delete" id="second_date_delete">
                    <div class="input_input_subtitle"><?php echo $langObj->getLabel("SLOT_TIME_TO_SUBLABEL"); ?></div>
                </div>
                
            </div>
            <div id="empty"></div>
            
            
             <div><input type="submit" class="ok_button" id="del_button" name="saveunpublish" value="OK"></div>  
            <div id="result_delete"></div>
            <div id="rowspace"></div>
        </form>
    </div>
    <div id="empty"></div>
</div>
<?php
}
?>
<!-- 
============================================================================================
===  ==
============================================================================================
-->


<div id="rowspace"></div>
<div id="rowline"></div>
<div id="rowspace"></div>



<a name="results" id="results"></a>
<div id="action_bar">
	<div id="action"><a onclick="javascript:delItems('manage_slots','slots[]','delSlots','<?php echo $langObj->getLabel("SLOTS_DELETE_MULTIPLE_ALERT");?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')"><?php echo $langObj->getLabel("CALENDARS_DELETE");?></a></div>
</div>
<form name="manage_slots" action="" method="post">
	<input type="hidden" name="operation" />
	<input type="hidden" name="slots[]" value=0 />
	<div id="table_container">
		<div id="table">
			<div class="slots_title_col1">
				<div id="table_cell">#</div>
			</div>
			<div class="slots_title_col2">
				<div id="table_cell"><input type="checkbox" name="selectAll" onclick="javascript:selectCheckbox('manage_slots','slots[]');" /></div>
			</div>
			<div class="slots_title_col3">
				<div id="table_cell"><?php echo $langObj->getLabel("SLOTS_DATE_LABEL");?>&nbsp;<a href="javascript:orderby('<?php echo $_SESSION["orderbySlotsDate"]; ?>');"><img src="images/orderby_<?php echo $_SESSION["orderbySlotsDate"];?>.gif" border=0 /></a></div>
			</div>
			<div class="slots_title_col4">
				<div id="table_cell"><?php echo $langObj->getLabel("SLOTS_TIME_FROM_LABEL");?>&nbsp;<a href="javascript:orderby('<?php echo $_SESSION["orderbySlotsTime"]; ?>');"><img src="images/orderby_<?php echo $_SESSION["orderbySlotsTime"];?>.gif" border=0 /></a></div>
			</div> 
            <div class="slots_title_col5">
				<div id="table_cell"><?php echo $langObj->getLabel("SLOTS_TIME_TO_LABEL");?></div>
			</div>
            
            <div class="slots_title_col6">
				<div id="table_cell"><?php echo $langObj->getLabel("SLOTS_SPECIAL_TEXT_LABEL");?></div>
			</div>      
            <div class="slots_title_col7">
				<div id="table_cell"><?php echo $langObj->getLabel("SLOTS_PRICE_LABEL");?></div>
			</div>
            <div class="slots_title_col8">
				<div id="table_cell"><?php echo $langObj->getLabel("SLOTS_AV_LABEL");?></div>
			</div>  
            <div class="slots_title_col9">
				<div id="table_cell"><?php echo $langObj->getLabel("SLOTS_AV_MAX_LABEL");?></div>
			</div>  
			<div class="slots_title_col10">
				<div id="table_cell"><?php echo $langObj->getLabel("SLOTS_RESERVATION_LABEL");?></div>
			</div>
			<div class="slots_title_col11">
				<div id="table_cell"></div>
			</div>
			<div class="slots_title_col12">
				<div id="table_cell"></div>
			</div>
			<div id="empty"></div>
			
		</div>
	</div>
</form>
<div id="cleardiv"></div>
<div id="rowspace"></div>
<iframe name="frame_submit" id="frame_submit"  style="width:0px;height:0px;border:0px;"></iframe>
